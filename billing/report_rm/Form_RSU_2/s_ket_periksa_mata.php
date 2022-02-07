<?php
//session_start();
include("../../sesi.php");
?>
<?php
//session_start();
include("../../koneksi/konek.php");
$user_id=$_SESSION['userId'];
$unit_id=$_SESSION['unitId'];
$idPasien=$_REQUEST['idPasien'];
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUsr'];

$usr=mysql_fetch_array(mysql_query("select nama from b_ms_pegawai where id='$idUser'"));
$sqlPas="SELECT DISTINCT 
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
  mp.telp
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  LEFT JOIN b_ms_pekerjaan bpek 
    ON bpek.id = mp.pekerjaan_id
  LEFT JOIN b_ms_agama bagm
    ON bagm.id = mp.agama 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
  LEFT JOIN b_tindakan bmt 
    ON k.id = bmt.kunjungan_id 
    AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_kelas mk 
    ON k.kso_kelas_id = mk.id 
  LEFT JOIN b_ms_kso kso 
    ON k.kso_id = kso.id 
  LEFT JOIN b_ms_unit un 
    ON un.id = p.unit_id 
  LEFT JOIN b_diagnosa diag 
    ON diag.kunjungan_id = k.id 
  LEFT JOIN b_ms_diagnosa md 
    ON md.id = diag.ms_diagnosa_id 
  LEFT JOIN b_ms_pegawai peg 
    ON peg.id = bmt.user_act 
  LEFT JOIN b_ms_pegawai peg1 
    ON bmt.user_id = peg1.id
  LEFT JOIN b_pasien_keluar bkel
    ON bkel.pelayanan_id = p.id
  LEFT JOIN b_ms_pegawai peg3
    ON peg3.id = bkel.dokter_id
  LEFT JOIN b_ms_kelas bmk
    ON bmk.id = p.kelas_id
WHERE k.id='$idKunj' AND p.id='$idPel'";

//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$isi = mysql_fetch_array($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
    <!-- untuk ajax-->

        <title>.: SURAT KETERANGAN PEMERIKSAAN MATA :.</title>
        <style>
        body{background:#FFF;}
        </style>
    </head>

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
                    <td colspan="3" align="center"><div id="metu" style="display:none;"><table width="700">
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
    <div align="center">
    <form id="form1" name="form1" action="s_ket_periksa_mata_utils.php" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
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
        <td><label for="textfield"></label>
          <input type="text" name="tajamlihat" id="tajamlihat" size="5" value="<?=$_POST['tajamlihat']?>"/></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">Mata Kanan</td>
        <td>:</td>
        <td><input type="text" name="mkanan" id="mkanan" size="5" value="<?=$_POST['mkanan']?>"/></td>
        <td colspan="5"><input name="tajam" id="tajam" type="radio" value="1" <?php if($_POST['tajam']=='1'){echo 'checked="checked"';}?>/>dengan / <input name="tajam" id="tajam" type="radio" value="2" <?php if($_POST['tajam']=='2'){echo 'checked="checked"';}?>/>tanpa kacamata</td>
        </tr>
      <tr>
        <td></td>
        <td colspan="2">Mata Kiri</td>
        <td>:</td>
        <td><input type="text" name="mkiri" id="mkiri" size="5" value="<?=$_POST['mkiri']?>"/></td>
        <td colspan="3"><input name="tajam2" id="tajam2" type="radio" value="1" <?php if($_POST['tajam2']=='1'){echo 'checked="checked"';}?>/>dengan / <input name="tajam2" id="tajam2" type="radio" value="2" <?php if($_POST['tajam2']=='2'){echo 'checked="checked"';}?>/>tanpa kacamata</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>2.</td>
        <td colspan="2">Segment. Anterior</td>
        <td>:</td>
        <td colspan="2"><label for="anterior1"></label> - Mata Kanan</td>
        <td colspan="4"><input type="text" name="anterior1" id="anterior1" value="<?=$_POST['anterior1']?>"/></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"><label for="anterior1"></label> - Mata Kiri</td>
        <td colspan="4"><input type="text" name="anterior2" id="anterior2" value="<?=$_POST['anterior2']?>"/></td>
        </tr>
      <tr>
        <td>3.</td>
        <td colspan="2">Segment. Posterior</td>
        <td>:</td>
        <td colspan="2"><label for="anterior1"></label> - Mata Kanan</td>
        <td colspan="4"><input type="text" name="posterior1" id="posterior1" value="<?=$_POST['posterior1']?>" /></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"><label for="anterior1"></label> - Mata Kiri</td>
        <td colspan="4"><input type="text" name="posterior2" id="posterior2" value="<?=$_POST['posterior2']?>" /></td>
        </tr>
      <tr>
        <td valign="top">4.</td>
        <td colspan="2">Penglihatan warna (Test Ishihara)</td>
        <td>:</td>
        <td colspan="6"><input type="text" name="wrn" id="wrn" value="<?=$_POST['wrn']?>"/></td>
        </tr>
      <tr>
        <td>5.</td>
        <td colspan="2">Catatan</td>
        <td>:</td>
        <td colspan="6" rowspan="5"><label for="catatan"></label>
          <textarea name="catatan" id="catatan" cols="30" rows="5"><?=$_POST['catatan']?></textarea></td>
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
      <tr id="trTombol">
        <td colspan="10" class="noline" align="center">
                    <input name="simpen" id="simpen" type="button" value="Simpan" onclick="simpan(this.value);" class="tblTambah"/>
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input id="liaten" type="button" value="View" onClick="return liat()" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
                </td>
        </tr>
    </table></form></div></td>
  </tr>
</table></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
                    <td height="30"><?php
                    if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnTambah" name="btnTambah" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                        <input type="button" id="btnEdit" name="btnEdit" value="Edit" onclick="edit(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" class="tblHapus"/>
                    <?php }?>    
                  </td>
                    <td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree">Cetak</button></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <!--Tindakan Unit:&nbsp;
                    <select id="cmbUnit" name="cmbUnit" class="txtinput" onchange="alert('s_ket_periksa_mata_utils.php?grd=true&unit='+document.getElementById('cmbUnit').value);">
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
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open('surat_ket_periksa_mata_view.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
				//}
		}
        //////////////////fungsi untuk tindakan////////////////////////
        function simpan(action)
        {
            if(ValidateForm('tajamlihat,mkanan,mkiri,anterior1,anterior2,posterior1,posterior2,wrn,catatan','ind'))
            {
                $("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					batal();
						a.loadURL("s_ket_periksa_mata_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
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
			$('#catatan').val(a.cellsGetValue(a.getSelRow(),12));
            var sisip=a.getRowId(a.getSelRow()).split("|");
            var p="txtId*-*"+sisip[0]+"*|*tajamlihat*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*mkanan*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*mkiri*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*anterior1*-*"+a.cellsGetValue(a.getSelRow(),7)+"*|*anterior2*-*"+a.cellsGetValue(a.getSelRow(),8)+"*|*posterior1*-*"+a.cellsGetValue(a.getSelRow(),9)+"*|*posterior2*-*"+a.cellsGetValue(a.getSelRow(),10)+"*|*wrn*-*"+a.cellsGetValue(a.getSelRow(),11)+"";
            //alert(p);
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
			centang(sisip[1],sisip[2]);
            
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
			$('#catatan').val('');
			var p="txtId*-**|*tajamlihat*-**|*mkanan*-**|*mkiri*-**|*anterior1*-**|*anterior2*-**|*posterior1*-**|*posterior2*-**|*wrn*-*";
			fSetValue(window,p);
			centang(1,1)
		}
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
                a.loadURL("s_ket_periksa_mata_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA SURAT KETERANGAN MATA");
        a.setColHeader("NO,TAJAM PENGLIHATAN,MATA KANAN,INFO,MATA KIRI,INFO,ANTERIOR MATA KANAN,ANTERIOR MATA KIRI,POSTERIOR MATA KANAN,POSTERIOR MATA KIRI,PENGLIHATAN WARNA,CATATAN");
        a.setIDColHeader(",,,,,,,,,,,");
        a.setColWidth("40,150,100,120,100,120,150,150,150,150,150,150");
        a.setCellAlign("center,left,left,left,left,left,left,left,left,left,left,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("s_ket_periksa_mata_utils.php?grd=true"+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>");
        a.Init();
		
		function centang(tes,tes2){
		 var checkbox = document.form1.elements['tajam'];
		 var checkboxlp = document.form1.elements['tajam2'];
		 
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
	}
	
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>

<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT pl.tgl as tgl2, mt.nama as nama_tindakan,  p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls, p.gol_darah as gol_darah2, u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2,a.rps as rps2, a.tb as tb2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_tindakan t ON t.pelayanan_id=pl.id
LEFT JOIN b_ms_tindakan mt ON mt.id=t.id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />

<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../../css/form.css" />

        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
		<script type="text/javascript" src="js/jquery.timeentry.js"></script>
		
		
		
		<script src="../../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../../../include/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>
		
        <script type="text/JavaScript">
		$(function () 
{
	$('#tex_jam').timeEntry({show24Hours: true, showSeconds: true});
	
});		
		
            var arrRange = depRange = [];
        </script>
<title>PEMAKAIAN ALKES DAN OBAT KAMAR BEDAH</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
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

.tblkembali{
	background-image:url(../../icon/back16.png);
	background-repeat:no-repeat;
	background-position:left;
	background-color:#CDD3D3;
	border:2px outset #000000;
	padding-left:15px;
}

        </style>
<title>resume kep</title>
<?
//include "setting2.php";
?>

<script type="text/JavaScript">
            var arrRange = depRange = [];
function tanggalan(){			
	$(function() {
		$( ".tgl" ).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../images/cal.gif",
			buttonImageOnly: true
		});	
	});
}

function jam(){			
	$(function () {
	$('.jam').timeEntry({show24Hours: true, showSeconds: true});
});
}
</script>


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
<form id="form1" name="form1" action="status_ugd_act.php">

<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="1077" height="447" border="0" style="font:12px tahoma;">
  <tr>
    <td width="446" height="174" style="font: 12px tahoma;"><p class="style1">&nbsp;</p>
      <p class="style1">&nbsp;</p>
      <p class="style1">&nbsp;</p>
      <p class="style1">&nbsp;</p>
      <p class="style1">STATUS UNIT GAWAT DARURAT </p></td>
    <td width="621" style="font: 12px tahoma;"><table width="493" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="121">Nama Pasien</td>
        <td width="166">:
          <?=$dP['nama'];?></td>
        <td width="74">&nbsp;</td>
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
          <?=$dP['no_rm'];?>        </td>
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
        <td colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" style="font:12px tahoma;"><table width="1076" height="831" border="1" class="style15"  style="border-collapse:collapse;">
      <tr>
        <td colspan="4"><table width="892" height="82" border="0">
          <tr>
            <td width="156"><strong> &nbsp;1. TRIAGE </strong></td>
            <td width="113">: 
              <label>
              <input name="cek_triage[0]" type="checkbox" id="cek_triage[]" value="0" />
              T1</label></td>
            <td width="115"><label>
              <input name="cek_triage[1]" type="checkbox" id="cek_triage[]" value="1" />
              T2</label></td>
            <td width="105"><label>
              <input name="cek_triage[2]" type="checkbox" id="cek_triage[]" value="2" />
              T3</label></td>
            <td width="78"><label>
              <input name="cek_triage[3]" type="checkbox" id="cek_triage[]" value="3" />
              T4</label></td>
            <td width="78">Tanggal</td>
            <td width="217">: 
              <label>
              <input name="tex_tgl" type="text" id="tex_tgl" onClick="gfPop.fPopCalendar(document.getElementById('tex_tgl'),depRange);"/>
              </label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>:
              <label>
              <input name="cek_trauma" type="radio" value="0" />
              Trauma</label>
              <label></label></td>
            <td><label>
              <input name="cek_trauma" type="radio" value="1" />
              Non Trauma</label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Jam</td>
            <td>: 
              <label>
              <input name="tex_jam" type="text" id="tex_jam" value=" <?=date('H:i:s')?>" />
              </label></td>
          </tr>
          <tr>
            <td>&nbsp;Cara Pasien Datang </td>
            <td>: 
              <label>
              <input name="cek_datang" type="radio" value="0" />
              Sendiri</label></td>
            <td><label>
              <input name="cek_datang" type="radio" value="1" />
              Diantar    &nbsp; &nbsp; &nbsp;:</label></td>
            <td><label>
              <div id="status" style="display: none"> <input style="display:inline;" name="tex_antar" type="text" size="15" id="tex_antar"/>
    </div>
            </label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;Kasus Polisi </td>
            <td>: 
              <label>
              <input name="cek_kasus" type="radio" value="1" />
              Ya</label></td>
            <td><label>
              <input name="cek_kasus" type="radio" value="0" />
              Tidak</label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="4" class="style15">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4"><table width="595" height="42" border="0">
          <tr>
            <td width="155">&nbsp;Riwayat Alergi </td>
            <td width="112">:
              <label>
              <input name="cek_riwayat" type="radio" value="1" />
              Ya</label></td>
            <td width="306"><label>
              <input name="cek_riwayat" type="radio" value="0" />
              Tidak</label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Bila Ya Sebutkan : 
              <label></label></td>
            <td><div id="status3" style="display: none"> <input style="display:inline;" name="tex_alergi" type="text" size="15" id="tex_alergi"/>
    </div> </td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="4"><table width="890" height="102" border="0">
          <tr>
            <td colspan="2">&nbsp;<strong>2. ANAMNESE &amp; PEMERIKSAAN FISIK : </strong></td>
            <td width="74"><label>
              <input name="cek_pemeriksaan" type="radio" value="0" />
              Auto</label></td>
            <td width="76"><label>
              <input name="cek_pemeriksaan" type="radio" value="1" />
              Allo &nbsp; &nbsp; : </label></td>
            <td width="481"><label> <div id="status2" style="display: none"> <input style="display:inline;" name="tex_fisik" type="text" size="15" id="tex_fisik"/>
    </div></label></td>
          </tr>
          <tr>
            <td width="198">&nbsp;Keluhan Utama </td>
            <td width="39">:</td>
            <td colspan="3"><label>
              <textarea name="tex_utama" cols="40" rows="1" id="tex_utama"></textarea>
            </label></td>
            </tr>
          <tr>
            <td>&nbsp;Keluhan Tambahan </td>
            <td>:</td>
            <td colspan="3"><label>
              <textarea name="tex_tambahan" cols="40" rows="1" id="tex_tambahan"></textarea>
            </label></td>
            </tr>
          <tr>
            <td>&nbsp;Riwayat Penyakit Sekarang </td>
            <td>:</td>
            <td colspan="3"><textarea name="tex_sekarang" cols="40" rows="1" id="tex_sekarang"></textarea></td>
            </tr>
          <tr>
            <td>&nbsp;Riwayat Penyakit Dahulu </td>
            <td>:</td>
            <td colspan="3"><textarea name="tex_dahulu" cols="40" rows="1" id="tex_dahulu"></textarea></td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table width="682" border="0">
          <tr>
            <td width="198">&nbsp;Keadaan Umum </td>
            <td width="87"><label>
              : 
                  <input name="cek_keadaan" type="radio" value="0" />
                  Baik</label></td>
            <td width="114"><label>
              <input name="cek_keadaan" type="radio" value="1" />
              Sedang</label></td>
            <td width="426"><label>
              <input name="cek_keadaan" type="radio" value="2" />
              Buruk</label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="233">&nbsp;Tekanan Darah : 
          <label>
          <?=$dP['tensi2'];?>
          mmHg</label></td>
        <td colspan="2">&nbsp;&nbsp;Nadi : 
          <label>
<?=$dP['nadi2'];?>          
x/mnt</label></td>
        <td width="502">&nbsp;&nbsp;Berat Badan : 
          <label>
          <?=$dP['bb2'];?>
          </label>
          Kg</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Pernapasan : 
           <label>
           <?=$dP['rps2'];?>
           </label> 
          x/mnt</td>
        <td colspan="2">&nbsp;&nbsp;Suhu : 
          <?=$dP['suhu2'];?> &deg;C </td>
        <td>&nbsp;&nbsp;Tinggi Badan : 
          <?=$dP['tb2'];?> Cm </td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;Status Neurologis </td>
        <td width="176"> &nbsp;&nbsp;E : 
          <label>
          <input name="tex_e" type="text" id="tex_e" size="7" />
          </label></td>
        <td width="137">&nbsp;&nbsp;M : 
          <input name="tex_m" type="text" id="tex_m" size="7" /></td>
        <td>&nbsp;&nbsp;V:
          <input name="tex_v" type="text" id="tex_v" size="7" /></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;kepala</td>
        <td colspan="3"><label>&nbsp;
          <input name="tex_kepala" type="text" id="tex_kepala" />
        </label></td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;Leher</td>
        <td colspan="3">&nbsp;&nbsp;<input name="tex_leher" type="text" id="tex_leher" /></td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;Dada</td>
        <td colspan="3">&nbsp;&nbsp;<input name="tex_dada" type="text" id="tex_dada" /></td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;Perut</td>
        <td colspan="3">&nbsp;&nbsp;<input name="tex_perut" type="text" id="tex_perut" /></td>
        </tr>
      <tr>
        <td>&nbsp;&nbsp;Kulit dan Kelamin </td>
        <td colspan="3">&nbsp;&nbsp;<input name="tex_kulit" type="text" id="tex_kulit" /></td>
        </tr>
      <tr>
        <td height="20">&nbsp;&nbsp;Alat Gerak </td>
        <td height="20" colspan="3">&nbsp;&nbsp;<input name="tex_alat" type="text" id="tex_alat" /></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center"><div align="left">
          <p>&nbsp;&nbsp;Nilai Nyeri / Pain Score : (Tidak ada nyeri / no pain - nyeri sangat berat / pain full )&nbsp;  </p>
          </div>
          <div align="center"><img src="gmb.jpg" width="700" height="180" /></div></td>
      </tr>
      <tr>
        <td colspan="4"><table width="893" border="0">
          <tr>
            <td width="90">&nbsp;</td>
            <td width="80">&nbsp;</td>
            <td width="44"><label>
              <input name="cek_n[0]" type="checkbox" id="cek_n[]" value="0" />
              0</label></td>
            <td width="42"><label>
              <input name="cek_n[1]" type="checkbox" id="cek_n[]" value="1" />
              1</label></td>
            <td width="47"><label>
              <input name="cek_n[2]" type="checkbox" id="cek_n[]" value="2" />
              2</label></td>
            <td width="36"><label>
              <input name="cek_n[3]" type="checkbox" id="cek_n[]" value="3" />
              3</label></td>
            <td width="40"><label>
              <input name="cek_n[4]" type="checkbox" id="cek_n[]" value="4" />
              4</label></td>
            <td width="40"><label>
              <input name="cek_n[5]" type="checkbox" id="cek_n[]" value="5" />
              5</label></td>
            <td width="48"><label>
              <input name="cek_n[6]" type="checkbox" id="cek_n[]" value="6" />
              6</label></td>
            <td width="39"><label>
              <input name="cek_n[7]" type="checkbox" id="cek_n[]" value="7" />
              7</label></td>
            <td width="44"><label>
              <input name="cek_n[8]" type="checkbox" id="cek_n[]" value="8" />
              8</label></td>
            <td width="43"><label>
              <input name="cek_n[9]" type="checkbox" id="cek_n[]" value="9" />
              9</label></td>
            <td width="127"><label>
              <input name="cek_n[10]" type="checkbox" id="cek_n[]" value="10" />
              10</label></td>
            <td width="62">&nbsp;</td>
            <td width="49">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4"><div align="center">
          <p>DAFTAR INFUS OBAT</p>
          <p align="left"> &nbsp;&nbsp;INFUS YANG DIBERIKAN :</p>
		  <div id="inInfus">
          <table width="763" height="101" border="1" align="center" class="tanggal" id="tblInfus" style="border-collapse:collapse">
            <tr bgcolor="#ababab">
              <td colspan="5" align="right" valign="middle" bgcolor="#FFFFFF"><input name="button22" type="button"  value="Tambah" class="tblTambah" onclick="addRowToTable2();return false;"/></td>
            </tr>
            <tr bgcolor="#ababab">
              <td width="159" align="center" bgcolor="#00FF66">Tanggal</td>
              <td width="144" align="center" bgcolor="#00FF66">Jam</td>
              <td width="136" align="center" bgcolor="#00FF66">Jenis Infus / Transfusi </td>
              <td width="151" align="center" bgcolor="#00FF66">Nama Dokter</td>
              <td width="60" align="center" bgcolor="#00FF66">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="center">
                <input type='text' class="tgl" name='tgla[]' id="tgla[]" />
                
              </div></td>
              <td><div align="center">
                <input type='text' class="jam" name="jam[]" id="jam[]" />
              </div></td>
              <td><div align="center">
                <input type='text' name="infus[]" id="infus[]"/>
              </div></td>
              <td><div align="center">
                <input type="text" id="nama" name='nama[]' />
                <?php /*?><?php
          $sql="select * from b_ms_pegawai where spesialisasi_id<>0";
          $query = mysql_query ($sql);
          while($data = mysql_fetch_array($query)){
		  ?>
          <option value="<?php echo $data['id'];?>" ><?php echo $data['nama']?></option>
          <?php
    	  }
	      ?><?php */?>
              </div></td>
              <td><div align="center"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable2(this);setDisable('del')}" /></div></td>
            </tr>
          </table>
		  </div>
          <p align="left">&nbsp; </p>
        </div></td>
        </tr>
      <tr>
        <td colspan="4">
          <p>&nbsp;&nbsp;OBAT - OBATAN YANG DIBERIKAN </p>
		  <div id="inObat">
          <table width="1061" height="122" border="1" align="center" class="tanggal" id="tblObat" style="border-collapse:collapse">
            <tr bgcolor="#ababab">
              <td colspan="7" align="right" valign="middle" bgcolor="#FFFFFF"><input name="button2" type="button"  value="Tambah" class="tblTambah" onclick="addRowToTable();return false;"/></td>
            </tr>
            <tr bgcolor="#ababab">
              <td width="159" align="center" bgcolor="#CCFF33">Tanggal</td>
              <td width="144" align="center" bgcolor="#CCFF33">Jam</td>
              <td width="144" align="center" bgcolor="#CCFF33">Nama Obat </td>
              <td width="144" align="center" bgcolor="#CCFF33">Dosis</td>
              <td width="136" align="center" bgcolor="#CCFF33">Cara Pemberian </td>
              <td width="151" align="center" bgcolor="#CCFF33">Nama Dokter</td>
              <td width="60" align="center" bgcolor="#CCFF33">&nbsp;</td>
            </tr>
            <tr>
              <td><div align="center">
                  <input name='tgll[]' type='text' class="tgl" id="tgll[]" size="20" onclick="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);" />
              </div></td>
              <td><div align="center">
                  <input name="jam2[]" type='text' class="jam" id="jam2[]" size="20" />
              </div></td>
              <td><div align="center">
                  <input name="obat[]" type='text' id="obat[]"/>
              </div></td>
              <td><div align="center">
                  <input name="dosis[]" type='text' id="dosis[]" size="20"/>
              </div></td>
              <td><div align="center">
                  <input name="pemberian[]" type='text' id="pemberian[]" size="20"/>
              </div></td>
              <td><div align="center">
                  <input name='nama2[]' type="text" id="nama2[]" size="20" />
                  <?php /*?><?php
          $sql="select * from b_ms_pegawai where spesialisasi_id<>0";
          $query = mysql_query ($sql);
          while($data = mysql_fetch_array($query)){
		  ?>
          <option value="<?php echo $data['id'];?>" ><?php echo $data['nama']?></option>
          <?php
    	  }
	      ?><?php */?>
              </div></td>
              <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}" /></td>
            </tr>
          </table></div>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td colspan="2" style="border:1px solid #000000;"><table width="800" border="0" align="center">
      <tr>
        <td width="790"></td>
      </tr>
      <tr>
        <td align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" /> 
          &nbsp;<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
      </tr>
      </table></td>
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
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
					  <input type="button" id="btnkembali" name="btnkembali" value="Kembali" onclick="kembali();" class="tblkembali"/>
                    </td>
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
			$('#tex_tgl').val(sisip[1]);
			$('#tex_jam').val(sisip[2]);
			centang(sisip[3]);
			cek_trauma(sisip[4]);
			cek_datang(sisip[5]);
			$('#tex_antar').val(sisip[6]);
			cek_kasus(sisip[7]);
			cek_riwayat(sisip[8]);
			$('#tex_alergi').val(sisip[9]);
			cek_pemeriksaan(sisip[10]);
			$('#tex_fisik').val(sisip[11]);
			$('#tex_utama').val(sisip[12]);
			$('#tex_tambahan').val(sisip[13]);
			$('#tex_sekarang').val(sisip[14]);
			$('#tex_dahulu').val(sisip[15]);
			cek_keadaan(sisip[16]);
			$('#tex_e').val(sisip[17]);
			$('#tex_m').val(sisip[18]);
			$('#tex_v').val(sisip[19]);
			$('#tex_kepala').val(sisip[20]);
			$('#tex_leher').val(sisip[21]);
			$('#tex_dada').val(sisip[22]);
			$('#tex_perut').val(sisip[23]);
			$('#tex_kulit').val(sisip[24]);
			$('#tex_alat').val(sisip[25]);
			cek_n(sisip[26]);
			$('#inObat').load("status_ugd_obat.php?type=ESO&id="+sisip[0]);
			$('#inInfus').load("status_ugd_infus.php?type=ESO&id="+sisip[0]);
			 $('#act').val('edit');
			 
            fSetValue(window,p);
			
        }
		
		function centang(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['cek_triage[]'];
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
		
			function cek_n(tes){
		var list=tes.split('*=*');
		var list1 = document.form1.elements['cek_n[]'];
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
		
		
		function cek_trauma(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['cek_trauma'];
		var list2 = document.form1.elements['cek_trauma'];
				
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
		  
		  function cek_datang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['cek_datang'];
		var list2 = document.form1.elements['cek_datang'];
				
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
		  
		   function cek_kasus(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['cek_kasus'];
		var list2 = document.form1.elements['cek_kasus'];
				
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
		  
		  
		  	   function cek_riwayat(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['cek_riwayat'];
		var list2 = document.form1.elements['cek_riwayat'];
				
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
		
		
		function cek_pemeriksaan(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['cek_pemeriksaan'];
		var list2 = document.form1.elements['cek_pemeriksaan'];
				
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
		
		function cek_keadaan(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['cek_keadaan'];
		var list2 = document.form1.elements['cek_keadaan'];
		var list3 = document.form1.elements['cek_keadaan'];
				
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
		 for (i = 2; i < list2.length; i++)
			{
			  if (list2[i].value==list[2])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
				
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
			
			
			$('#inObat').load("status_ugd_obat.php");
			$('#inInfus').load("status_ugd_infus.php");
		//toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			document.getElementById('form1').reset();
			//$('#id').val('');
			//$('#txt_anjuran').val('');
            $('#inObat').load("status_ugd_form.php");
			//centang(1,'L')
			}




        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("status_ugd_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Status UGD");
        a.setColHeader("NO,NAMA PASIEN,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",nama,,,");
        a.setColWidth("20,300,150,120");
        a.setCellAlign("center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("status_ugd_util.php?idPel=<?=$idPel?>");
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
		window.open("status_ugd.php?id="+id+"&idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUsr?>","_blank");
		document.getElementById('id').value="";
				//}
		}
		
		function kembali(){
		window.close();                                                // Closes the new window                                           

		}
		

	
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

            var cellRight = row.insertCell(0);
            var el;
            var tree;
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tgll[]';
                el.id = 'tgll[]';
				//el.onClick =gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);
				el.size = 20;
				
            }else{
                el = document.createElement('<input name="tgll[]" />');
				//el.onClick="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);"
            }
            el.type = 'text';
            //el.value = 'ff';
			//el.onClick ="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange)";

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
           		 el.value = '';
			//	 el.size = 20;
				
            

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
                el.name = 'jam2[]';
                el.id = 'jam2[]';
            }else{
                el = document.createElement('<input name="jam2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'obat[]';
                el.id = 'obat[]';
            }else{
                el = document.createElement('<input name="nama2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'dosis[]';
                el.id = 'dosis[]';
            }else{
                el = document.createElement('<input name="dosis[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;
            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'pemberian[]';
                el.id = 'pemberian[]';
            }else{
                el = document.createElement('<input name="pemberian[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;
            //el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'nama2[]';
                el.id = 'nama2[]';
            }else{
                el = document.createElement('<input name="nama2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);


			
 // right cell
                cellRight = row.insertCell(6);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

      
<?php
//echo $sel;
?>

  cellRightSel.appendChild(el);

    }

function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 2)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=1;i<lastRow;i++)
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
            var tbl = document.getElementById('tblInfus');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};

            var cellRight = row.insertCell(0);
            var el;
            var tree;
            if(!isIE){
                el = document.createElement('input');
                el.name = 'tgla[]';
                el.id = 'tgla[]';
				//el.onClick =gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);
				el.size = 20;
				
            }else{
                el = document.createElement('<input name="tgla[]" />');
				//el.onClick="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange);"
            }
            el.type = 'text';
            //el.value = 'ff';
			//el.onClick ="gfPop.fPopCalendar(document.getElementById('tgll[]'),depRange)";

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
           		 el.value = '';
			//	 el.size = 20;
				
            

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
                el.name = 'jam[]';
                el.id = 'jam[]';
            }else{
                el = document.createElement('<input name="jam[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'infus[]';
                el.id = 'infus[]';
            }else{
                el = document.createElement('<input name="infus[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'nama[]';
                el.id = 'nama[]';
            }else{
                el = document.createElement('<input name="nama[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 20;
            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
			
 // right cell
                cellRight = row.insertCell(4);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable2(this);}"/>');
                }
                el.src = '../../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

      
<?php
//echo $sel;
?>

  cellRightSel.appendChild(el);

    }

function removeRowFromTable2(cRow)
	{
        var tbl = document.getElementById('tblInfus');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 2)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=1;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('id');
                //tds[0].innerHTML=i-2;
            }
        }
    }



$('input:radio[name="cek_datang"]').change(
    function tampil(){
        if ($(this).val() == 1) {
            $('#status').slideDown(600);
        }
        else {
            $('#status').slideUp(600);
			//$('#status').checked(false);
			document.getElementById('tex_antar').value="";
        }
		
    });

$('input:radio[name="cek_pemeriksaan"]').change(
    function tampil1(){
        if ($(this).val() == 1) {
            $('#status2').slideDown(600);
        }
        else {
            $('#status2').slideUp(600);
			//$('#status').checked(false);
			document.getElementById('tex_fisik').value="";
        }
		
    });
	
	
$('input:radio[name="cek_riwayat"]').change(
    function tampil2(){
        if ($(this).val() == 1) {
            $('#status3').slideDown(600);
        }
        else {
            $('#status3').slideUp(600);
			//$('#status').checked(false);
			document.getElementById('tex_alergi').value="";
        }
		
    });



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
	
	
    td1.innerHTML="<input type='text' class='tgl' name='tgl[]' id='tgl"+idx+"'>";tanggalan();
    td2.innerHTML="<input type='text' class='jam' name='jam[]' id='jam"+idx+"'>";jam();
	td3.innerHTML="<input type='text' id='infus' name='infus[]'>";
    td4.innerHTML="<input type='text' id='dokter' name='nama[]'>";
	td5.innerHTML="<input type='button' value='Hapus' onclick='del()' class='tblHapus' />";
    idrow++;
}

function del(){
    if(idrow>3){
        var x=document.getElementById('datatable').deleteRow(idrow-1);
        idrow--;
    }
}


</script>




<script>
var idrow2 = 3;
function tambahrow2(){
    var x=document.getElementById('datatable2').insertRow(idrow2);
	var idx2 = $('.tanggal tr').length;
	var idx = idx2-3;
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	var td6=x.insertCell(5);
	var td7=x.insertCell(6);
	
	
    td1.innerHTML="<input type='text' class='tgl' name='tgll[]' id='tgll"+idx+"'>";tanggalan();
    td2.innerHTML="<input type='text' class='jam' name='jam2[]' id='jam2"+idx+"'>";jam();
	td3.innerHTML="<input type='text' id='obat' name='obat[]'>";
	td4.innerHTML="<input type='text' id='dosis' name='dosis[]'>";
	td5.innerHTML="<input type='text' id='pemberian' name='pemberian[]'>";
    td6.innerHTML="<input type='text' id='nama2' name='nama2[]'>";
	td7.innerHTML="<input type='button' value='Hapus' onclick='del2()' class='tblHapus' />";
    idrow2++;
}

function del2(){
    if(idrow2>3){
        var y=document.getElementById('datatable2').deleteRow(idrow2-1);
        idrow2--;
    }
}


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

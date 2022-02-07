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
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
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
<title>TIMEOUT CHECKLIST</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style3 {font-size: 14px}
-->
</style>
</head>
<?
//include "../../billing/koneksi/konek.php";
include("../../sesi.php");
include("../../koneksi/konek.php");
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
$sql2="SELECT * FROM b_timeout_checklist where pelayanan_id='$idPel'";
$dP2=mysql_fetch_array(mysql_query($sql2));
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
<div id="form_input" align="center" style="display:none">
<form id="form1" name="form1" action="Time_OutCheck_LIst_act.php">
<table width="806" border="0" style="font:12px tahoma">
  <tr>
    <td width="800" align="left"><table width="810" border="0">
      <tr>
        <td width="337" height="100">&nbsp;</td>
        <td width="453" rowspan="2"><table width="457" border="0" style="border:1px solid #000000">
      <tr>
        <td width="108">Nama Pasien </td>
        <td colspan="3">: 
          <?=$dP['nama'];?></td>
        </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>: 
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td width="85">&nbsp;</td>
        <td width="85">&nbsp;</td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td> : 
          <?=$dP['sex'];?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?> Tahun</td>
      </tr>
      <tr>
        <td>No R.M </td>
        <td>: 
          <?=$dP['no_rm'];?></td>
        <td>No registrasi </td>
        <td>:_________</td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td colspan="3">: 
          <?=$dP['nm_unit'];?> / 
          <?=$dP['nm_kls'];?></td>
        </tr>
      <tr>
        <td height="20">Alamat</td>
        <td colspan="3">: 
          <?=$dP['alamat'];?></td>
        </tr>
      <tr>
        <td height="21" colspan="4"><div align="center">(Tempelkan sticker identitas pasien)</div></td>
        </tr>
    </table></td>
      </tr>
      <tr>
        <td height="20"><span class="style1">TIME OUT CHECK LIST</span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="798" border="0" style="border-collapse:collapse">
      <tr>
        <td height="34" colspan="5" style="border-left:1px solid #000000;border-top:1px solid #000000;border-right:1px solid #000000;"><span class="style3">Tanggal Tindakan / Prosedur</span></td>
        </tr>
      <tr>
        <td height="22" colspan="3" style="border-left:1px solid #000000;border-top:1px solid #000000;"><div align="center"><strong>RUANG PERSIAPAN </strong></div></td>
        <td colspan="2" style="border-top:1px solid #000000;border-right:1px solid #000000;"><div align="center"><strong>Perawatan</strong></div></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;border-top:1px solid #000000;">&nbsp;</td>
        <td colspan="2" style="border-top:1px solid #000000;">
        <input type="hidden" size="2" name="act" id="act" value="tambah" />
            <input type="hidden" name="id" id="id" value="" />
            <input type="hidden" name="idPel" id="idPel" value="<?php echo $idPel; ?>" />
            <input type="hidden" name="idUsr" id="idUsr" value="<?php echo $idUsr; ?>" />
      		<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
      		<input type="hidden" name="idPasien" value="<?=$idPasien?>" /></td>
        <td style="border-top:1px solid #000000;"><div align="center">Ya</div></td>
        <td style="border-top:1px solid #000000;border-right:1px solid #000000;"><div align="center">Tidak</div></td>
      </tr>
      <tr>
        <td width="13" style="border-left:1px solid #000000;">1.</td>
        <td colspan="2">Verifikasi Identitas pasien (gelang identitas, catatan, dan pasien)</td>
        <td width="71"><div align="center">
          <input type="radio" name="list_1" value="1" id="list_1" />
        </div></td>
        <td width="70" style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_1" value="0" id="list_1" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">2.</td>
        <td colspan="2">Kelengkapan Informed Consent</td>
        <td><div align="center">
          <input type="radio" name="list_2" value="1" id="list_2" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_2" value="0" id="list_2" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">3.</td>
        <td colspan="2">&quot;Marking&quot; area operasi sesuai dengan prosedur</td>
        <td><div align="center">
          <input type="radio" name="list_3" value="1" id="list_3" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_3" value="0" id="list_3" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">4.</td>
        <td colspan="2">Pengkajian pre operasi dan kelengkapan check list</td>
        <td><div align="center">
          <input type="radio" name="list_4" value="1" id="list_4" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_4" value="0" id="list_4" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">5.</td>
        <td colspan="2">Riwayat fisik dan rencana operasi oleh dokter bedah (tanggal terakhir)</td>
        <td><div align="center">
          <input type="radio" name="list_5" value="1" id="list_5" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_5" value="0" id="list_5" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">6.</td>
        <td colspan="2">Adanya pengkaijan Pre Anaesthesi dan Informed Consent Anastesi</td>
        <td><div align="center">
          <input type="radio" name="list_6" value="1" id="list_6" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_6" value="0" id="list_6" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">7.</td>
        <td colspan="2">Dokumen Laboratorium, radiology, dan test lain yang diperlukan</td>
        <td><div align="center">
          <input type="radio" name="list_7" value="1" id="list_7" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_7" value="0" id="list_7" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">8.</td>
        <td colspan="2">Tersedia alat khusus dan obat - obatan yang diperlukan dan siap digunakan</td>
        <td><div align="center">
          <input type="radio" name="list_8" value="1" id="list_8" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="list_8" value="0" id="list_8" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td width="309">&nbsp;</td>
        <td width="321">&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td colspan="4" style="border-right:1px solid #000000;">Perawat di Ruang Pre - Operasi :</td>
        </tr>
      <tr>
        <td height="46" style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>..........................................</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td> &nbsp;&nbsp;(Nama dan Tanda Tangan)</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" style="border-left:1px solid #000000; border-bottom:1px solid #000000;"><div align="center"><strong>TIME - OUT DI KAMAR OPERASI</strong></div></td>
        <td colspan="2" style="border-right:1px solid #000000; border-bottom:1px solid #000000;"><div align="center"><strong>Dokter Bedah</strong></div></td>
        </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-right:1px solid #000000;"><em>Sebelum dimulainya prosedur semua anggota team yang akan mengopersi pasien tersebut hadir dan memperhatikan proses &quot; TIME OUT&quot; dipimpin oleh dokter bedah.</em></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Ya</div></td>
        <td style="border-right:1px solid #000000;"><div align="center">Tidak</div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">1.</td>
        <td colspan="2">Anggota Team memastikan nama pasien, prosedur dan area yang dioperasi</td>
        <td><div align="center">
          <input type="radio" name="cek_1" value="1" id="cek_1" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="cek_1" value="0" id="cek_1" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td colspan="2">(Informed Consent, gelang nama dan formulir pre operasi )</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">2.</td>
        <td>Dokter Bedah Menjelaskan antisipasi terhadap </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>a. Komplikasi</td>
        <td>: 
          <label>
          <input name="komplikasi_kamar" type="text" id="komplikasi_kamar" size="30" />
          </label></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>b. Perkiraan kehilangan darah (mL)</td>
        <td>: 
          <label>
          <input name="kehilangan_darah" type="text" id="kehilangan_darah" size="8" />
          ml</label></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>c. Rencana penempatan setelah operasi</td>
        <td>:
          <label>
          <select name="r_pemindahan_pasien" id="r_pemindahan_pasien">
          <option value="">--Pilih--</option>
            <option>Pulang</option>
            <option>Ruangan</option>
            <option>ICU</option>
            <option>ICCU</option>
            <option>HCU</option>
                    </select>
          </label></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">3.</td>
        <td>Antibiotik Profilaksis</td>
        <td>: 
          <label>
          <input name="antibiotik" type="text" id="antibiotik" size="35" />
          </label></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">4.</td>
        <td>Alergi Obat</td>
        <td>: 
          <label>
          <input name="alergi" type="text" id="alergi" size="40" />
          </label></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000";>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><table width="800" border="0">
          <tr>
            <td><div align="center">Dokter Bedah</div></td>
            <td><div align="center">Dokter Anastesi</div></td>
            <td><div align="center">Perawat Sirkulasi</div></td>
          </tr>
          <tr>
            <td height="48"><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
          </tr>
          <tr>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
          </tr>
          <tr>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="3" style="border-left:1px solid #000000; border-bottom:1px solid #000000;"><div align="center"><strong>SEBELUM KELUAR KAMAR OPERASI</strong></div></td>
        <td colspan="2" style="border-bottom:1px solid #000000; border-right:1px solid #000000;"><div align="center"><strong>Dokter Bedah</strong></div></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Ya</div></td>
        <td style="border-right:1px solid #000000;"><div align="center">Tidak</div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">1.</td>
        <td>Tindakan yang dilakukan sesuai rencana</td>
        <td>&nbsp;</td>
        <td><div align="center">
          <input type="radio" name="cek_2" value="1" id="cek_2" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="cek_2" value="0" id="cek_2" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">2.</td>
        <td>Penghitungan kassa, jarum, instrumen sudah benar</td>
        <td>&nbsp;</td>
        <td><div align="center">
          <input type="radio" name="cek_3" value="1" id="cek_3" />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input type="radio" name="cek_3" value="0" id="cek_3" />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">3.</td>
        <td>Pemindahan pasien ke :</td>
        <td><label>
          :
          <select name="pemindahan_pasien" id="pemindahan_pasien">
          <option value="">--Pilih--</option>
            <option>Pulang</option>
            <option>Ruangan</option>
            <option>ICU</option>
            <option>ICCU</option>
            <option>HCU</option>
                    </select>
        </label></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">4.</td>
        <td>Komplikasi</td>
        <td>: 
          <label>
          <input type="text" name="komplikasi_sebelum" id="komplikasi_sebelum" />
          </label></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-right:1px solid #000000;"><table width="800" border="0">
          <tr>
            <td><div align="center">Dokter Bedah</div></td>
            <td><div align="center">Dokter Anastesi</div></td>
            <td><div align="center">Perawat Sirkulasi</div></td>
          </tr>
          <tr>
            <td height="48"><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
          </tr>
          <tr>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-right:1px solid #000000;">Beri tanda <img src="centang.png" width="14" height="19" />Pada kotak yang tersedia </td>
        </tr>
      
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="center" style="border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />
      <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
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
    <td><input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/></td>
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
            if(ValidateForm('komplikasi_kamar,kehilangan_darah,r_pemindahan_pasien,antibiotik,alergi,pemindahan_pasien,komplikasi_sebelum')){
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
			 var p="id*-*"+sisip[0]+"*|*komplikasi_kamar*-*"+sisip[3]+"*|*kehilangan_darah*-*"+sisip[4]+"*|*r_pemindahan_pasien*-*"+sisip[5]+"*|*antibiotik*-*"+sisip[6]+"*|*alergi*-*"+sisip[7]+"*|*pemindahan_pasien*-*"+sisip[8]+"*|*komplikasi_sebelum*-*"+sisip[9]+"";
			 centang(sisip[1]);
			 cek(sisip[2]);
			 //$('#act').val('edit');
			 
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
            a.loadURL("Time_OutCheck_LIst_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&id=<?=$id?>&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Timeout Check List");
        a.setColHeader("NO,KOMPLIKASI TIME - OUT DI KAMAR OPERASI,KEHILANGAN DARAH,RENCANA PENEMPATAN,ANTIBIOTIK PROFILAKSIS,ALERGI OBAT,PEMINDAHAN PASIEN,KOMPLIKASI SEBELUM KELUAR KAMAR OPERASI,TANGGAL INPUT,PENGGUNA");
        a.setIDColHeader(",,,,,,,,,,,,,");
        a.setColWidth("20,200,80,80,100,80,100,200,100,100");
        a.setCellAlign("center,center,center,center,center,center,center,center,center,center");
        a.setCellHeight(20);
		a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("Time_OutCheck_LIst_util.php?id=<?=$id?>&idPel=<?=$idPel?>");
        a.Init();
		
		
		
		
		function cetak()
		{
			var id = document.getElementById("id").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			/*if(id=='')
			{
				alert("Pilih data terlebih dahulu untuk di cetak");
			}
			else*/
			{	
				window.open("Time_OutCheck_LIst.php?id="+id+"&idPel=<?=$idPel?>&idUser=<?=$idUsr?>","_blank");
				document.getElementById('id').value="";
			}
			
		}
		
function centang(tes){
		var list=tes.split(',');
		var list1 = document.form1.elements['list_1'];
		var list2 = document.form1.elements['list_2'];
		var list3 = document.form1.elements['list_3'];
		var list4 = document.form1.elements['list_4'];
		var list5 = document.form1.elements['list_5'];
		var list6 = document.form1.elements['list_6'];
		var list7 = document.form1.elements['list_7'];
		var list8 = document.form1.elements['list_8'];
		
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
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			  if (list2[i].value==list[1])
			  {
			   list2[i].checked = true;
			  }
		  }
		}
		if ( list3.length > 0 )
		{
		 for (i = 0; i < list3.length; i++)
			{
			  if (list3[i].value==list[2])
			  {
			   list3[i].checked = true;
			  }
		  }
		}
		if ( list4.length > 0 )
		{
		 for (i = 0; i < list4.length; i++)
			{
			  if (list4[i].value==list[3])
			  {
			   list4[i].checked = true;
			  }
		  }
		}
		if ( list5.length > 0 )
		{
		 for (i = 0; i < list5.length; i++)
			{
			  if (list5[i].value==list[4])
			  {
			   list5[i].checked = true;
			  }
		  }
		}
		if ( list6.length > 0 )
		{
		 for (i = 0; i < list6.length; i++)
			{
			  if (list6[i].value==list[5])
			  {
			   list6[i].checked = true;
			  }
		  }
		}
		if ( list7.length > 0 )
		{
		 for (i = 0; i < list7.length; i++)
			{
			  if (list7[i].value==list[6])
			  {
			   list7[i].checked = true;
			  }
		  }
		}
		if ( list8.length > 0 )
		{
		 for (i = 0; i < list8.length; i++)
			{
			  if (list8[i].value==list[7])
			  {
			   list8[i].checked = true;
			  }
		  }
		}
	}
	
	function cek(tes2){
		var cek=tes2.split(',');
		var cek1 = document.form1.elements['cek_1'];
		var cek2 = document.form1.elements['cek_2'];
		var cek3 = document.form1.elements['cek_3'];
		
		if ( cek1.length > 0 )
		{
		 for (i = 0; i < cek1.length; i++)
			{
			  if (cek1[i].value==cek[0])
			  {
			   cek1[i].checked = true;
			  }
		  }
		}
		if ( cek2.length > 0 )
		{
		 for (i = 0; i < cek2.length; i++)
			{
			  if (cek2[i].value==cek[1])
			  {
			   cek2[i].checked = true;
			  }
		  }
		}
		if ( cek3.length > 0 )
		{
		 for (i = 0; i < cek3.length; i++)
			{
			  if (cek3[i].value==cek[2])
			  {
			   cek3[i].checked = true;
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
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>

<!--DB = b_form_catatan_pra_bedah-->
<?
include('../../koneksi/konek.php');
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, an.`BB`, an.`TB`, pg.`id` AS id_user
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN `anamnese` an ON an.`KUNJ_ID`=pl.`kunjungan_id`
WHERE pl.id='$idPel'"; //$idPel
$dP=mysql_fetch_array(mysql_query($sqlP));

if($dP['sex']=='L'){
	$jk='Laki-laki';
}else{
	$jk='Perempuan';
}
	
?>
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
        <script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script type="text/JavaScript">
var arrRange = depRange = [];
	</script>   
</script>  
       <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
<script type="text/javascript">
$(function () 
{
	$('#jam').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam2').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
    <!-- untuk ajax-->
    
        <title>.: CATATAN PERJITUNGAN KASA/ JARUM/ INSTRUMEN :.</title>
        <style>
        body{background:#FFF;}
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
vertical-align:middle; 
text-align:center;
}
        #form_in #form1 table tr th div table tr td {
	font-family: Tahoma, Geneva, sans-serif;
}
        </style>
    <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
</head>

<body >
<iframe height="193" width="168" name="gToday:normal:agenda.js"
    id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe> 
<iframe height="72" width="130" name="sort"
    id="sort"
    src="../../theme/dsgrid_sort.php" scrolling="no"
    frameborder="0"
    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>

<div id="form_in" align="center" style="display:blok">
    <form id="form1" name="form1" action="42.catatan_keperawatan_pra_bedah_act.php">
    	<p>
    	  <input type="hidden" name="idPel" value="<?=$idPel?>" />
    	  <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    	  <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    	  <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    	  <input type="hidden" name="txtId" id="txtId"/>
    	  <input type="hidden" name="act" id="act" value="tambah"/>
   	  </p>
    	<table width="1000" border="1" style="border-collapse:collapse">
    	  <tr>
    	    <td><table width="1000">
    	      <tr>
    	        <th scope="col">&nbsp;</th>
  	        </tr>
    	      <tr style="border:1px solid #000;">
    	        <td><p align="center"><strong>PEMERINTAH KOTA MEDAN</strong></p>
    	          <p align="center"><strong>RUMAH SAKIT PELINDO I</strong></p>
    	          <p align="center">Jl. xxx</p>
    	          <p align="center">Telp xxx</p></td>
  	        </tr>
    	      <tr>
    	        <td><div style="border:1px double #000"></div></td>
  	        </tr>
    	      <tr>
    	        <td><table width="500">
    	          <tr>
    	            <th width="163" scope="col">&nbsp;</th>
    	            <th width="19" scope="col">&nbsp;</th>
    	            <th width="302" scope="col">&nbsp;</th>
  	            </tr>
    	          <tr>
    	            <td><strong>NO. RM</strong></td>
    	            <td><strong>:</strong></td>
    	            <td><?=$dP['no_rm'];?></td>
  	            </tr>
    	          <tr>
    	            <td><strong>NAMA</strong></td>
    	            <td><strong>:</strong></td>
    	            <td><?=$dP['nama'];?></td>
  	            </tr>
    	          <tr>
    	            <td><strong>UMUR</strong></td>
    	            <td><strong>:</strong></td>
    	            <td><?=$dP['usia'];?>
    	              &nbsp;
    	              Tahun</td>
  	            </tr>
    	          <tr>
    	            <td><strong>JENIS KELAMIN</strong></td>
    	            <td><strong>:</strong></td>
    	            <td><?=$jk?></td>
  	            </tr>
  	          </table></td>
  	        </tr>
    	      <tr>
    	        <td>&nbsp;</td>
  	        </tr>
    	      <tr>
    	        <td><div align="center"><strong>CATATAN KEPERAWATAN PRA BEDAH</strong></div></td>
  	        </tr>
    	      <tr>
    	        <td>&nbsp;</td>
  	        </tr>
    	      <tr>
    	        <td><table width="1000" border="1" style="border-collapse:collapse">
    	          <tr style="border:1px solid #000">
    	            <td><div align="center">
    	              <p><strong>RUANG RAWAT</strong></p>
    	              <p>
    	                <input type="text" name="ruang" id="ruang" />
  	                </p>
    	              <p>&nbsp;</p>
  	              </div></td>
    	            <td><div align="center">
    	              <p><strong>TGL.OPERASI</strong></p>
    	              <input name="tgl" type="text" id="tgl" class="txtinput" tabindex="4" value="<?php echo $tanggal;?>" size="10" maxlength="15" readonly="readonly"/>
    	              <img alt="calender" style="cursor:pointer" border="0" src="../../images/cal.gif" align="absbottom" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" />
    	              <p>&nbsp;</p>
  	              </div></td>
    	            <td colspan="3"><div align="center">
    	              <p><strong>TINDAKAN OPERASI YANG AKAN DILAKUKAN</strong></p>
    	              <div align="right">
    	                <table width="200">
    	                  <tr>
    	                    <td width="100">Kanan
    	                      <input type="checkbox" name="kanan" id="kanan" value="1"/></td>
    	                    <td width="100">Kiri
    	                      <input type="checkbox" name="kiri" id="kiri" value="1"/></td>
  	                    </tr>
  	                  </table>
  	                </div>
    	              <p>&nbsp;</p>
  	              </div></td>
  	            </tr>
  	          </table></td>
  	        </tr>
    	      <tr>
    	        <td>&nbsp;</td>
  	        </tr>
    	      <tr>
    	        <td><table width="1000" border="1" style="border-collapse:collapse">
    	          <tr>
    	            <th scope="col"><div align="center">NO</div></th>
    	            <th scope="col">ASPEK YANG DINILAI</th>
    	            <th colspan="4" scope="col">PERAWAT</th>
  	            </tr>
    	          <tr>
    	            <td><div align="center"></div></td>
    	            <td>&nbsp;</td>
    	            <td><div align="center"><strong>RUANGAN</strong></div></td>
    	            <td><div align="center"><strong>OK</strong></div></td>
    	            <td><div align="center"><strong>ANASTESI</strong></div></td>
    	            <td><div align="center"><strong>KET</strong></div></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">1</div></td>
    	            <td>Lapangan operasi dicukur</td>
    	            <td><label for="ruangan"></label>
    	              <input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[0]" id="status[]" value="1"/>
  	              </div>
    	              <label for="status"></label></td>
    	            <td><label for="anastesi"></label>
    	              <input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td width="35"><label for="keterangan"></label>
    	              <input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">2</div></td>
    	            <td>Puasa</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[1]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">3</div></td>
    	            <td>Ijin operasi / Inform Consent</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[2]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">4</div></td>
    	            <td>TD, N, S, RR</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[3]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">5</div></td>
    	            <td>Kateter</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[4]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">6</div></td>
    	            <td>Infus</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[5]" id="status[]" value="1" />
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">7</div></td>
    	            <td>Huknah</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[6]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">8</div></td>
    	            <td>Obat premidikasi diberikan</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[7]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">9</div></td>
    	            <td>Barang berharga/perhiasan diamankan</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[8]" id="status[]" value="1" />
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">10</div></td>
    	            <td>Tata rias dan cat kuku dihapus</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[9]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">11</div></td>
    	            <td>Gigi palsu / rambut palsu / contact lens / hearing aid dilepas</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[10]" id="status[]" value="1" />
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">12</div></td>
    	            <td>HasilEKG / Lab / radioli terlampir</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[11]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">13</div></td>
    	            <td>Status lengkap</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[12]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">14</div></td>
    	            <td>Darah dan golongan darah</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[13]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">15</div></td>
    	            <td>Konsul anastesi</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[14]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">16</div></td>
    	            <td>Konsul kardiologi</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[15]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">17</div></td>
    	            <td>Konsul penyakit dalam</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[16]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">18</div></td>
    	            <td>Konsul paru-paru</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[17]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">19</div></td>
    	            <td>Konsul anak</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[18]" id="status[]" value="1"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">20</div></td>
    	            <td>Pemasangan label</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[19]" id="status[]" value="1" />
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">21</div></td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">22</div></td>
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
    	      <tr>
    	        <td>PERSIAPAN DI KAMAR OPERASI PUKUL :
    	          <input name="jam" type="text" id="jam" size="10" /></td>
  	        </tr>
    	      <tr>
    	        <td><table width="1000">
    	          <tr>
    	            <th width="202" scope="col">&nbsp;</th>
    	            <th width="177" scope="col">&nbsp;</th>
    	            <th width="328" scope="col">&nbsp;</th>
    	            <th width="273" scope="col">&nbsp;</th>
  	            </tr>
    	          <tr>
    	            <td>Perawat Kamar Operasi</td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td>Perawat Ruangan</td>
  	            </tr>
    	          <tr>
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
  	            </tr>
    	          <tr>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
  	            </tr>
    	          <tr>
    	            <td><input name="perawat_kamar" type="text" id="perawat_kamar" size="30" /></td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td><input name="perawat_ruangan" type="text" id="perawat_ruangan" size="30" /></td>
  	            </tr>
  	          </table></td>
  	        </tr>
    	      <tr>
    	        <td>&nbsp;</td>
  	        </tr>
  	      </table></td>
  	    </tr>
  	  </table>
    	<p>&nbsp;</p>
    	<p>&nbsp;</p>
</form>
    
    <BR />
    <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
</div>
<div id="tampil_data" align="center">
<p>&nbsp;</p>
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="2"><?php
                    if($_REQUEST['report']!=1){
					?>
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus2" name="btnHapus2" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  <?php }?>                 </td>
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
                        <div id="gridbox" style=" height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style=""></div></td>
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
</html>

<script>
function toggle() {
   // parent.alertsize(document.body.scrollHeight);
}

function simpan(action){
	if(ValidateForm('ruang','ind')){
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


function hapus(){
	var rowid = document.getElementById("txtId").value;
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	if(rowid==''){
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
	var rowid = document.getElementById("txtId").value;
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	if(rowid==''){
			alert("Pilih data terlebih dahulu");
	}else{
		$('#act').val('edit');
		$('#form_in').slideDown(1000,function(){
			toggle();
			});
		}
}

function batal(){
	resetF();
	$('#form_in').slideUp(1000,function(){
		toggle();
	});
}
		

function tambah(){
	resetF();
		$('#form_in').slideDown(1000,function(){
	toggle();
	});
}


function cetak(){
	 var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(rowid==''){
			alert("Pilih data terlebih dahulu");
		}else{	
	window.open("40.catatan_penghitungan_kasa_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
		}
}


function goFilterAndSort(grd){
	a.loadURL("42.catatan_keperawatan_pra_bedah_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
}
	
var a=new DSGridObject("gridbox");
a.setHeader("CATATAN KEPERAWATAN PRA BEDAH");
a.setColHeader("NO,NAMA PASIEN,TGL OPERASI, PERAWAT KAMAR OPERASI,PERAWAT RUANGAN,TGL INPUT,PENGGUNA");
a.setIDColHeader(",nama,tgl_operasi,perawat_kamar,perawat_ruangan,tgl_act,nama_user");
a.setColWidth("50,100,100,180,100,100,150");
a.setCellAlign("center,center,left,center,center,center,center");
a.setCellHeight(20);
a.setImgPath("../../icon");
a.setIDPaging("paging");
a.attachEvent("onRowClick","ambilData");
//a.onLoaded(konfirmasi);
a.baseURL("42.catatan_keperawatan_pra_bedah_util.php?idPel=<?=$idPel?>");
a.Init();


function hapus(){
	var rowid = document.getElementById("txtId").value;
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	if(rowid==''){
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

function resetF(){
	$('#act').val('tambah');
	$('#txtId').val('');
	document.getElementById("form1").reset();
	$('#intable').load("40.tabel_catatan.php?type=cek");
}

function ambilData(){		
	var sisip = a.getRowId(a.getSelRow()).split('*');
	$('#txtId').val(sisip[0]);
	$('#ruang').val(sisip[1]);
	$('#tgl').val(a.cellsGetValue(a.getSelRow(),3));
	var tindakan = sisip[2];
	var tin = tindakan.split('|');

	if(tin[0]==1){
		document.getElementById("kanan").checked=true;
	}else{
		document.getElementById("kanan").checked=false;
	}
	if(tin[1]==1){
		document.getElementById("kiri").checked=true;
	}else{
		document.getElementById("kiri").checked=false;
	}
	$('#jam').val(sisip[3]);
	$('#perawat_kamar').val(a.cellsGetValue(a.getSelRow(),4));
	$('#perawat_ruangan').val(a.cellsGetValue(a.getSelRow(),5));
	cekdata(sisip[4],0);
	cekdata(sisip[5],1);
	cekdata(sisip[6],2);
	cekdata(sisip[7],3);
	cekdata(sisip[8],4);
	cekdata(sisip[9],5);
	cekdata(sisip[10],6);
	cekdata(sisip[11],7);
	cekdata(sisip[12],8);
	cekdata(sisip[13],9);
	cekdata(sisip[14],10);
	cekdata(sisip[15],11);
	cekdata(sisip[16],12);
	cekdata(sisip[17],13);
	cekdata(sisip[18],14);
	cekdata(sisip[19],15);
	cekdata(sisip[20],16);
	cekdata(sisip[21],17);
	cekdata(sisip[22],18);
	cekdata(sisip[23],19);
	//alert(sisip[4]);
	$('#act').val('edit');
	
}

function cekdata(x,y){
	var data = x.split('|');
	var ruang = document.form1.elements['ruangan[]'];
	var ok = document.form1.elements['status[]'];
	var anastesi = document.form1.elements['anastesi[]'];
	var ket = document.form1.elements['keterangan[]'];
	//alert(data[1]);
	ruang[y].value=data[0];
	anastesi[y].value=data[2];
	ket[y].value=data[3];
	if(data[1]==1){
		ok[y].checked = true;
	}else{
		ok[y].checked = false	
	}
}



</script>
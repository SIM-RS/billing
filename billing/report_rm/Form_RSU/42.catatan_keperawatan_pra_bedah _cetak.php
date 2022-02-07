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

$id=$_REQUEST['id'];
$sql2 = "select * from b_form_catatan_pra_bedah where id='$id'";	
$data=mysql_fetch_array(mysql_query($sql2));

$xx = $data['tindakan'];
$cek=explode("|",$xx);
if($cek[0]==1){
	$status="checked='checked'";
}else{
	$status='';	
}
if($cek[1]==1){
	$status1="checked='checked'";
}else{
	$status1='';	
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

<script>

</script>
<body onload="cekdata('<?=$data['lapangan_operasi']?>',0),cekdata('<?=$data['puasa']?>',1),cekdata('<?=$data['ijin_operasi']?>',2),cekdata('<?=$data['TD']?>',3),cekdata('<?=$data['kateter']?>',4),cekdata('<?=$data['infus']?>',5),cekdata('<?=$data['huknah']?>',6),cekdata('<?=$data['obat_pramedikasi']?>',7),cekdata('<?=$data['barang_berharga']?>',8),cekdata('<?=$data['tata_rias']?>',9),cekdata('<?=$data['gigi_palsu']?>',10),cekdata('<?=$data['hasil_ekg']?>',11),cekdata('<?=$data['status_lengkap']?>',12),cekdata('<?=$data['darah_dan_golongan']?>',13),cekdata('<?=$data['konsul_anastesi']?>',14),cekdata('<?=$data['konsul_kardiologi']?>',15),cekdata('<?=$data['konsul_penyakit']?>',16),cekdata('<?=$data['konsul_paru']?>',17),cekdata('<?=$data['konsul_anak']?>',18),cekdata('<?=$data['pemasangan_label']?>',19), nonaktif()">

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
    	                <?=$data['ruang'];?>
  	                </p>
    	              <p>&nbsp;</p>
  	              </div></td>
    	            <td><div align="center">
    	              <p><strong>TGL.OPERASI</strong></p>
    	              <p>
    	                <?=tglSQL($data['tgl_operasi']);?>
    	              </p>
    	              <p>&nbsp;</p>
  	              </div></td>
    	            <td colspan="3"><div align="center">
    	              <p><strong>TINDAKAN OPERASI YANG AKAN DILAKUKAN</strong></p>
    	              <div align="right">
    	                <table width="200">
    	                  <tr>
    	                    <td width="100">Kanan
    	                      <input type="checkbox" name="kanan" id="kanan" disabled="disabled" <? echo $status; ?>/></td>
    	                    <td width="100">Kiri
    	                      <input type="checkbox" name="kiri" id="kiri" disabled="disabled" <? echo $status1; ?>/></td>
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
    	              <input type="checkbox" name="status[0]" id="status[]" disabled="disabled"/>
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
    	              <input type="checkbox" name="status[1]" id="status[]"disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">3</div></td>
    	            <td>Ijin operasi / Inform Consent</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[2]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">4</div></td>
    	            <td>TD, N, S, RR</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[3]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">5</div></td>
    	            <td>Kateter</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[4]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">6</div></td>
    	            <td>Infus</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[5]" id="status[]"disabled="disabled" />
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">7</div></td>
    	            <td>Huknah</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[6]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">8</div></td>
    	            <td>Obat premidikasi diberikan</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[7]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">9</div></td>
    	            <td>Barang berharga/perhiasan diamankan</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[8]" id="status[]" disabled="disabled" />
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">10</div></td>
    	            <td>Tata rias dan cat kuku dihapus</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[9]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">11</div></td>
    	            <td>Gigi palsu / rambut palsu / contact lens / hearing aid dilepas</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[10]" id="status[]" disabled="disabled" />
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">12</div></td>
    	            <td>HasilEKG / Lab / radioli terlampir</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[11]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">13</div></td>
    	            <td>Status lengkap</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[12]" id="status[]"disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">14</div></td>
    	            <td>Darah dan golongan darah</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[13]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">15</div></td>
    	            <td>Konsul anastesi</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[14]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">16</div></td>
    	            <td>Konsul kardiologi</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[15]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">17</div></td>
    	            <td>Konsul penyakit dalam</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[16]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">18</div></td>
    	            <td>Konsul paru-paru</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[17]" id="status[]"disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">19</div></td>
    	            <td>Konsul anak</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[18]" id="status[]" disabled="disabled"/>
  	              </div></td>
    	            <td><input name="anastesi[]" type="text" id="anastesi[]" size="30" /></td>
    	            <td><input name="keterangan[]" type="text" id="keterangan[]" size="25" /></td>
  	            </tr>
    	          <tr>
    	            <td><div align="center">20</div></td>
    	            <td>Pemasangan label</td>
    	            <td><input type="text" name="ruangan[]" id="ruangan[]" /></td>
    	            <td><div align="center">
    	              <input type="checkbox" name="status[19]" id="status[]" disabled="disabled" />
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
    	        <td>PERSIAPAN DI KAMAR OPERASI PUKUL :  &nbsp;  	          
   	            <?=$data['jam_persiapan'];?></td>
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
    	            <td><?=$data['perawat_kamar'];?></td>
    	            <td>&nbsp;</td>
    	            <td>&nbsp;</td>
    	            <td><?=$data['perawat_ruangan'];?></td>
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
    <div align="center">&nbsp;</div>
</div>
<div id="tampil_data" align="center">
<p>&nbsp;</p>
</div>

</body>
</html>

<script>

function cek(){
var x = '<? echo 'qwerty'?>';
//var x = 'xxx';
alert(x);
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

function nonaktif(){
	var ruang1 = document.form1.elements['ruangan[]'];
	var anastesi1 = document.form1.elements['anastesi[]'];
	var ket1 = document.form1.elements['keterangan[]'];
	
	for(i=0; i<ruang1.length; i++){
		ruang1[i].disabled=true;
		anastesi1[i].disabled=true;
		ket1[i].disabled=true;
	}
}

</script>
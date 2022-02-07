<!--DB = b_form_catatan_penghitung , b_form_catatan_penghitung_detail-->
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
$id=$_REQUEST['id'];

$sql1="select * from b_form_catatan_penghitung where id='$id'";

$data=mysql_fetch_array(mysql_query($sql1));


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
    <form id="form1" name="form1" action="40.catatan_penghitung_kasa_act.php">
    	<p>
    	  <input type="hidden" name="idPel" value="<?=$idPel?>" />
    	  <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    	  <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    	  <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    	  <input type="hidden" name="txtId" id="txtId"/>
    	  <input type="hidden" name="act" id="act" value="tambah"/>
   	  </p>
    	<p>&nbsp; </p>
    	<table align="center" cellpadding="2" cellspacing="0" style="border-collapse:collapse; border:1px solid #000000;" width="1150">
          <col width="40" />
          <col width="55" />
          <col width="64" span="9" />
          <tr>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td style="border-top:#000 1px solid;">&nbsp;</td>
            <td colspan="4" rowspan="8" style="border-top:#000 1px solid;"><table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
              <tr>
                <td width="135"><strong>Nama Pasien</strong></td>
                <td colspan="2">:
                  <?=$dP['nama'];?></td>
                <td width="99">&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Tanggal Lahir</strong></td>
                <td width="68">:
                  <?=tglSQL($dP['tgl_lahir']);?></td>
                <td width="76">Usia</td>
                <td>:
                  <?=$dP['usia'];?>
                  Thn</td>
              </tr>
              <tr>
                <td><strong>No. RM</strong></td>
                <td>:
                  <?=$dP['no_rm'];?></td>
                <td>No Registrasi </td>
                <td>:____________</td>
              </tr>
              <tr>
                <td><strong>Ruang Rawat/Kelas</strong></td>
                <td colspan="2">:
                  <?=$dP['nm_unit'];?>
                  /
                  <?=$dP['nm_kls'];?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>Alamat</strong></td>
                <td colspan="2">:
                  <?=$dP['alamat'];?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="4"><center>
                  <strong>(Tempelkan Sticker Identitas Pasien)</strong>
                </center></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="6" ><div align="center"><strong>PEMERINTAH KOTA MEDAN </strong></div></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="6" ><div align="center"><strong>RUMAH SAKIT PELINDO I</strong></div></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
           <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td colspan="2" ><strong>RUANG OPERASI</strong></td>
            <td ><strong>:</strong></td>
            <td ><?=$data['ruang_operasi'];?></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td colspan="6" ><strong>CATATAN PENGHITUNGAN KASA/ JARUM/ INSTRUMEN</strong></td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <td colspan="12" style="border-top:#000 1px solid;">&nbsp;</td>
          </tr>
          <tr>
            <td width="1">&nbsp;</td>
            <td colspan="10"><table style="font:12px tahoma; border:1px solid #000;">
              <tr>
                <td width="777" align="center"><div id="intable">
                  <table width="1060" border="1" id="tblkegiatan" cellpadding="2" style="border-collapse:collapse;">
                    <tr style="background:#338FC1">
                      <td colspan="12" align="right">&nbsp;</td>
                    </tr>
                    <tr style="background:#6CF">
                      <td width="228" align="center"><strong>JENIS</strong></td>
                      <td width="163" align="center"><strong>JUMLAH AWAL</strong></td>
                      <td colspan="5" align="center"><strong>TAMBAHAN</strong></td>
                      <td width="149" align="center"><strong>JUMLAH<BR />SEMENTARA*</strong></td>
                      <td width="64" align="center"><strong>TAMBAHAN</strong></td>
                      <td width="44" align="center"><strong>JUMLAH<BR />AKHIR</strong></td>
                      <td width="210" align="center"><strong>KETERANGAN</strong></td>
                      
                    </tr>
                    <?
					$sql2="select * from b_form_catatan_penghitung_detail where id_form_catatan_penghitung ='$id'";	
					$query=mysql_query($sql2);
					while($data2=mysql_fetch_object($query)){
						?>
                        	 <tr>
                              <td align="center" width="35"><?=$data2->jenis;?></td>
                              <td align="center"><?=$data2->jumlah_awal;?></td>
                              <td width="18" align="center"><?=$data2->tambahan1;?></td>
                              <td width="18" align="center"><?=$data2->tambahan2;?></td>
                              <td width="18" align="center"><?=$data2->tambahan3;?></td>
                              <td width="18" align="center"><?=$data2->tambahan4;?></td>
                              <td width="18" align="center"><?=$data2->tambahan5;?></td>
                              <td align="center"><?=$data2->jumlah_sementara;?></td>
                              <td align="center"><?=$data2->tambahanx;?></td>
                              <td align="center"><?=$data2->jumlah_akhir;?></td>
                              <td align="center"><?=$data2->keterangan;?></td>           
                            </tr>           
                        <?
					}
					?>
                   
                  </table>
                </div></td>
              </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="153">&nbsp;</td>
            <td width="15"></td>
            <td width="189"></td>
            <td width="63"></td>
            <td width="18"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" rowspan="4"><table width="522" border="1" style="border-collapse:collapse">
              <tr>
                <th width="181" scope="col">&nbsp;</th>
                <th width="155" scope="col">Nama Jelas</th>
                <th width="164" scope="col">Tanda Tangan</th>
              </tr>
              <tr>
                <td>Ahli Bedah</td>
                <td><?=$data['ahli_bedah']?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Perawat Instrumen</td>
                <td><?=$data['perawat_instrumen']?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Perawat Sirkuler</td>
                <td><?=$data['perawat_sirkuler']?></td>
                <td>&nbsp;</td>
              </tr>
            </table>
            </td>
            <td></td>
            <td>Jumlah kasa</td>
            <td colspan="2">: 
              <label>
                <input type="radio" name="jumlah_kasa" value="b" id="jumlah_kasa1" disabled="disabled" <? if($data['jumlah_kasa']=='b'){echo 'checked=checked';}?>/> Benar </label> 
              <label>
                /
                <input type="radio" name="jumlah_kasa" value="t" id="jumlah_kasa2" disabled="disabled" <? if($data['jumlah_kasa']=='t'){echo 'checked=checked';}?>/>
              Tidak</label>
             
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td>Jumlah jarum</td>
            <td colspan="2">: 
              
                <label>
                  <input type="radio" name="jumlah_jarum" value="b" id="jumlah_jarum1" disabled="disabled" <? if($data['jumlah_jarum']=='b'){echo 'checked=checked';}?>/>
                  Benar</label> 
                /
                <label>
                  <input type="radio" name="jumlah_jarum" value="t" id="jumlah_jarum2" disabled="disabled" <? if($data['jumlah_jarum']=='t'){echo 'checked=checked';}?> />
                  Tidak</label>
                <br />
           </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td>Jumlah Instrumen</td>
            <td colspan="2">:
             
              <label>
                  <input type="radio" name="jumlah_instrumen" value="b" id="jumlah_instrumen1" disabled="disabled" <? if($data['jumlah_instrumen']=='b'){echo 'checked=checked';}?>/>
                  Benar</label> 
              /
                <label>
                  <input type="radio" name="jumlah_instrumen" value="t" id="jumlah_instrumen2" disabled="disabled" <? if($data['jumlah_instrumen']=='t'){echo 'checked=checked';}?>/>
              Tidak</label>
                <br />
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td></td>
            <td>Jumlah pisau / <em>Blade</em></td>
            <td colspan="2">:
             
              <label>
                  <input type="radio" name="jumlah_pisau" value="b" id="jumlah_pisau1" disabled="disabled" <? if($data['jumlah_pisau']=='b'){echo 'checked=checked';}?>/>
                  Benar</label> 
              /
                <label>
                  <input type="radio" name="jumlah_pisau" value="t" id="jumlah_pisau2" disabled="disabled" <? if($data['jumlah_pisau']=='t'){echo 'checked=checked';}?>/>
              Tidak</label>
                <br />
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Lain-lain :..................</td>
            <td colspan="2">:</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Jenis Operasi</td>
            <td>:</td>
            <td><?=$data['jenis_operasi']?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tanggal</td>
            <td>:</td>
            <td><?=tglSQL($data['tanggal'])?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Jam mulai</td>
            <td>:</td>
            <td><?=$data['jam_mulai']?>             
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3">* Jumlah sementara adalah jumlah sebelum kulit/ rongga ditutup</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Jam selesai</td>
            <td>:</td>
            <td><?=$data['jam_selesai']?>            
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td width="145"></td>
            <td width="7"></td>
            <td width="213"></td>
            <td width="12"></td>
            <td width="272"></td>
            <td width="12">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
    </form>
    
   
</div>

<br>
<div align="center">&nbsp;
<input type="submit" name="button" id="button" value="Cetak" onclick="cetak1() " />
</div>
<br><br><br>
</body>
</html>

<script>
function cetak1()
{
	document.getElementById("button").style.display = 'none';
	window.print();
	document.getElementById("button").style.display = 'table-row';
}
</script>
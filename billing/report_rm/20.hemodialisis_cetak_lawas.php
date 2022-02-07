<!--b_ms_hemodialisis, b_ms_hemodialisis_detail-->

<?
include "../koneksi/konek.php";
$id=$_REQUEST['id'];
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
$id=$_REQUEST['id'];

$sql1="select * from b_ms_hemodialisis where id='$id'";
$data=mysql_fetch_array(mysql_query($sql1));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css" />
<link type="text/css" rel="stylesheet" href="js/jquery.timeentry.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.timeentry.js"></script>
        <script type="text/javascript" src="js/jquery.timeentry.min.js"></script>
        <script type="text/javascript">

</script>

        <!-- end untuk ajax-->
        <title>HEMODIALISIS</title>
        <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
<title>resume kep</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->

</style>
<link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../css/form.css" />
<!--<link rel="stylesheet" type="text/css" href="../include/jquery/jquery-ui-timepicker-addon.css" />
<script src="../js/jquery-1.8.3.js"></script>-->
<script src="../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../include/jquery/ui/jquery.ui.datepicker.js"></script>
<script src="../include/jquery/jquery-ui-timepicker-addon.js"></script>
<script src="../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>


<?
include "setting.php";
?>

<script type="text/JavaScript">
            var arrRange = depRange = [];
function tanggalan(){			
	$(function() {
		$( ".tgl" ).datepicker({
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../images/cal.gif",
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
</head>

<body onload="checked_off();cek();">
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
<div id="tampil_input" align="center" style="display:blok">
<form name="form1" id="form1" action="20.hemodialisis_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$dP['id']?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="3" align="center" valign="middle"><img src="Form_RSU_2/lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" /></td>
    <td colspan="2" rowspan="2" align="right" valign="bottom"><table width="383" border="0" cellpadding="4" style="border:1px solid #000000;">
      <tr>
        <td width="110">Nama Pasien </td>
        <td width="7">:</td>
        <td width="232"><?=$nama;?> (<?=$sex;?>)</td>
        </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>:</td>
        <td><?=$tgl;?> /Usia : <?=$umur;?> th </td>
        </tr>
      <tr>
        <td>No. RM </td>
        <td>:</td>
        <td><?=$noRM;?> No. Registrasi : <?=$no_reg;?></td>
        </tr>
      <tr>
        <td>Ruang Rawat/Kelas </td>
        <td>:</td>
        <td><?=$kamar;?> / <?=$kelas;?></td>
        </tr>
      <tr>
        <td height="23">Alamat</td>
        <td>:</td>
        <td><?=$alamat;?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="344">&nbsp;</td>
    <td width="6">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="900" border="1" style="border-collapse:collapse">
      <tr>
        <td><table width="900">
          <tr>
            <td>Tanggal&nbsp;:&nbsp;<?=tglSQL($data['tanggal1'])?> </td>
            <td>Pukul&nbsp;:&nbsp;<?=$data['pukul1'];?></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><table width="900">
          <tr>
            <td>Alergi : 
              <?php 
			//echo $dP['id'];
				$sqlA="SELECT * from b_riwayat_alergi
				WHERE pasien_id='188';";//".$dP['id']."
				$exA=mysql_query($sqlA);
				while($dA=mysql_fetch_array($exA)){?>
              <?=$dA['riwayat_alergi'].'<br>';
					$pantangan = $dA['riwayat_alergi'];
					?>
              
              <?php }?>
              </td>
            <td><input type="checkbox" name="check[0]" id="check[]" value="0"/>
              <label for="a">Obat</label></td>
            <td><input type="checkbox" name="check[1]" id="check[]" value="1" />
              Makanan</td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><table width="900">
          <tr>
            <td><strong>PENGKAJIAN</strong></td>
            <td>Resiko Jatuh</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>Assestment</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="checkbox" name="check[2]" id="check[]" value="2"/> 
              Tidak
  </td>
            <td><input type="checkbox" name="check[3]" id="check[]" value="3"/>
              Rendah</td>
            <td><input type="checkbox" name="check[4]" id="check[]" value="4"/> 
              Sedang
  </td>
            <td><input type="checkbox" name="check[5]" id="check[]" valu="5"/> 
              Tinggi
  </td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><table width="900" border="1" style="border-collapse:collapse">
          <tr>
            <td width="300" scope="col"><table width="300">
              <tr>
                <td scope="col"><strong>RIWAYAT</strong></td>
                </tr>
              <tr>
                <td>History : </td>
                </tr>
              <tr>
                <td><?=$data['riwayat']?>
                  <!--<textarea name="riwayat" id="riwayat" cols="45" rows="5"></textarea>--></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                </tr>
              </table></td>
            <td width="584" scope="col"><table width="584">
              <tr>
                <td colspan="3"><strong>Status Nutrisi</strong></td>
                <td width="233">&nbsp;</td>
                <td width="175">&nbsp;</td>
                </tr>
              <tr>
                <td colspan="3">BB Kering : <?=$bb;?> Kg</td>
                <td>TB : <?=$tb;?> cm</td>
                <td>BMI :&nbsp;<?=$data['bmi']?> 
                  
                  Kg/m2</td>
                </tr>
              <tr>
                <td colspan="5"><div style="border:1px solid #000"></div></td>
                </tr>
              <tr>
                <td width="155"><strong>Keadaan Umum</strong></td>
                <td width="17">:</td>
                <td colspan="3"><strong>GCS E V M</strong></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="117">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td><strong>Pemeriksaan Fisik</strong></td>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                </tr>
              <tr>
                <td>Mata </td>
                <td>:</td>
                <td colspan="3"><?=$data['mata']?> </td>
                </tr>
              <tr>
                <td>Pulma</td>
                <td>:</td>
                <td colspan="3"><?=$pulma?></td>
                </tr>
              <tr>
                <td>Cor</td>
                <td>:</td>
                <td colspan="3"><?=$cor?></td>
                </tr>
              <tr>
                <td>Abdomen</td>
                <td>:</td>
                <td colspan="3"><?=$abdomen?></td>
                </tr>
              <tr>
                <td>Eksiremitas</td>
                <td>:</td>
                <td colspan="3"><?=$eks?></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="5"><table width="900" border="1" style="border-collapse:collapse">
      <tr>
        <td><strong>Diagnosa medis : </strong><?=$diag;?></td>
        </tr>
      <tr>
        <td><table width="900">
          <tr>
            <td width="70">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="70">&nbsp;</td>
            </tr>
          <tr>
            <td colspan="15"><div align="center">
              <table width="800" border="1" style="border-collapse:collapse">
                <tr>
                  <td><table width="800">
                    <tr>
                      <td colspan="4"><strong>SKALA NYERI</strong></td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td width="100"><em>Pain Score</em></td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td width="50">&nbsp;</td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td width="100">&nbsp;</td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td width="50">&uarr;<div style="border:1px solid #000"></div></td>
                      <td>&nbsp;</td>
                      </tr>
                    <tr>
                      <td width="100">&nbsp;</td>
                      <td width="50">0
                        <input type="checkbox" name="check[6]" id="check[]" valu="6"/></td>
                      <td width="50">1
                        <input type="checkbox" name="check[7]" id="check[]" value="7"/></td>
                      <td width="50">2
                        <input type="checkbox" name="check[8]" id="check[]" value="8"/></td>
                      <td width="50">3
                        <input type="checkbox" name="check[9]" id="check[]" value="9"/></td>
                      <td width="50">4
                        <input type="checkbox" name="check[10]" id="check[]" value="10"/></td>
                      <td width="50">5
                        <input type="checkbox" name="check[11]" id="check[]" /></td>
                      <td width="50">6
                        <input type="checkbox" name="check[12]" id="check[]" value="12"/></td>
                      <td width="50">7
                        <input type="checkbox" name="check[13]" id="check[]" value="13"/></td>
                      <td width="50">8
                        <input type="checkbox" name="check[14]" id="check[]" value="14" /></td>
                      <td width="50">9
                        <input type="checkbox" name="check[15]" id="check[]" value="15" /></td>
                      <td width="50">10
                        <input type="checkbox" name="check[16]" id="check[]" value="16" /></td>
                      <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><table width="900" border="1" style="border-collapse:collapse">
          <tr>
            <td scope="col"><table width="450">
              <tr>
                <td width="117">BB Pre HD&nbsp;:&nbsp;<?=$data['bb_pre_hd']?>&nbsp;Kg   
                 </td>
                <td width="79">&nbsp;</td>
                <td width="19">&nbsp;</td>
                <td colspan="2">BB Post HD&nbsp;:&nbsp;<?=$data['bb_post_hd']?>&nbsp;Kg</td>
                </tr>
              <tr>
                <td colspan="2">Intradialek Weight Gain&nbsp;:&nbsp;<?=$data['iwg']?>&nbsp;Kg</td>
                <td>&nbsp;</td>
                <td width="115">&nbsp;</td>
                <td width="96">&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="3"><strong>Tanda - tanda vital</strong></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="2">Tensi / <em>Blood Presure (BP)</em></td>
                <td>:</td>
                <td><?=$tensi?>                   mmHg</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="2">Nadi / <em>Heart Rate (HR)</em></td>
                <td>:</td>
                <td><?=$nadi?>                   x/min</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="2">Respirasi / Respiration Rate (RR)</td>
                <td>:</td>
                <td><?=$Respirasi?>                   x/min</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="2">Suhu / <em>Temperature (T)</em></td>
                <td>:</td>
                <td><?=$suhu?> &deg;C</td>
                <td>&nbsp;</td>
                </tr>
              </table></td>
            <td scope="col"><table width="450
            
            ">
              <tr>
                <td colspan="3" scope="col"><strong>PROGRAM HD</strong></td>
                <td width="78" scope="col">&nbsp;</td>
                <td width="70" scope="col">&nbsp;</td>
                <td width="10" scope="col">&nbsp;</td>
                <td width="122" scope="col">&nbsp;</td>
                </tr>
              <tr>
                <td width="56">Lama</td>
                
                <td width="7">:</td>
                <td colspan="2"><?=$data['lama']?> Jam</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>QB</td>
                <td>:</td>
                <td colspan="2"><?=$data['qb_program']?> mil/jam</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>QD</td>
                <td>:</td>
                <td colspan="2"><?=$data['qd_program']?> mil/jam</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>UF Goal</td>
                <td>:</td>
                <td colspan="2"><?=$data['ufg_program']?> L</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Haparin</td>
                <td>:</td>
                <td width="75"><input type="checkbox" name="check[17]" id="check[]" value="17" /> 
                  Reguler</td>
                <td>&nbsp;</td>
                <td>Dosis</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[18]" id="check[]" value="18" /> 
                  Minimal</td>
                <td>&nbsp;</td>
                <td>awal</td>
                <td>:</td>
                <td><?=$data['dosis_awal']?> U</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[19]" id="check[]" value="19"/> 
                  Free</td>
                <td>&nbsp;</td>
                <td>Maintenance</td>
                <td>:</td>
                <td><?=$data['maintenance']?> U</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><table width="900">
          <tr>
            <td colspan="3"><strong>Profil Hemodialisa</strong></td>
            <td width="92">&nbsp;</td>
            <td width="87">&nbsp;</td>
            <td width="71">&nbsp;</td>
            <td width="115">&nbsp;</td>
            <td width="46">&nbsp;</td>
            <td width="46">&nbsp;</td>
            <td width="50">&nbsp;</td>
            </tr>
          <tr>
            <td width="126">Mesin No : <?=$data['mesin_no']?></td>
            <td width="152">Jenis Dialiser : <?=$data['jenis_dialiser']?></td>
            <td width="71"><input type="checkbox" name="check[20]" id="check[]" value="20"/> 
              New</td>
            <td><input type="checkbox" name="check[21]" id="check[]" value="21" />
              Rouse</td>
            <td colspan="3">Tipe Dialiser  : <?=$data['tipe_dialiser']?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>Blood Access</td>
            <td><input type="checkbox" name="check[22]" id="check[]" value="22"/> 
              AV Shunt</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Jenis Dialisat</td>
            <td><input type="checkbox" name="check[23]" id="check[]" value="23" /></td>
            <td>Bikarbonat</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="checkbox" name="check[24]" id="check[]" value="24" /> 
              Famoral</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="checkbox" name="check[25]" id="check[]" value="25" /> 
              Catheter Double Lumen</td>
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
        <td><table width="900" border="1" style="border-collapse:collapse;">
          <tr>
            <td scope="col"><table width="450">
              <tr>
                <td width="25">&nbsp;</td>
                <td colspan="2"><strong>Masalah yang ditemukan :</strong></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="23"><input type="checkbox" name="check[26]" id="check[]" value="26" /></td>
                <td width="386">Tidak efektifnya pola nafas</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[27]" id="check[]" value="27"/></td>
                <td>Gangguan keseimbangan cairan dan elektrolit</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[28]" id="check[]" value="28" /></td>
                <td>Resiko tinggi infeksi</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[29]" id="check[]" value="29"/></td>
                <td>Resiko terjadi disequilibrium</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[30]" id="check[]" value="30"/></td>
                <td>Resiko terjadinya pembekuan darah pada <em>blood line</em></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[31]" id="check[]" value="31"/></td>
                <td>Tidak efektifnya program HD</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table></td>
            <td scope="col"><table width="450">
              <tr>
                <td width="25">&nbsp;</td>
                <td colspan="2"><strong>Penyulit selama HD</strong></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="18"><input type="checkbox" name="check[32]" id="check[]" value="32" /></td>
                <td width="391"> Pendarahan</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[33]" id="check[]" value="33" /></td>
                <td>Gatal-gatal</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[34]" id="check[]" value="34" /></td>
                <td>Alergi terhadap dializer</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[35]" id="check[]" value="35" /></td>
                <td>Sakit Kepala</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[36]" id="check[]" value="36" /></td>
                <td>Mual dan muntah</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[37]" id="check[]" value="37" /></td>
                <td>Sakit dada</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[38]" id="check[]" value="38" /></td>
                <td>Hipotensi</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[39]" id="check[]" value="39" /></td>
                <td>Menggigil dingin</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[40]" id="check[]" value="40"/></td>
                <td>Kram</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[41]" id="check[]" value="41"/></td>
                <td>Lain-lain</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><table width="900" border="1" style="border-collapse:collapse">
          <tr>
            <td scope="col"><table width="300">
              <tr>
                <td colspan="4" scope="col"><strong>Pengawasan cairan selama HD</strong></td>
                </tr>
              <tr>
                <td width="19">1.</td>
                <td width="91">Volume priming</td>
                <td width="11">:</td>
                <td><?=$data['volume_priming']?> ml</td>
                </tr>
              <tr>
                <td>2.</td>
                <td>Cairan keluar</td>
                <td>:</td>
                <td><?=$data['cairan_keluar']?> ml</td>
                </tr>
              <tr>
                <td>3.</td>
                <td>Sisa priming</td>
                <td>:</td>
                <td><?=$data['sisa_priming']?> ml</td>
                </tr>
              <tr>
                <td>4.</td>
                <td>Cairan drip</td>
                <td>:</td>
                <td><?=$data['cairan_drip']?> ml</td>
                </tr>
              <tr>
                <td>5.</td>
                <td>Darah</td>
                <td>:</td>
                <td><?=$data['darah']?> ml</td>
                </tr>
              <tr>
                <td>6.</td>
                <td>Wash Out</td>
                <td>:</td>
                <td><?=$data['wash_out']?> ml</td>
                </tr>
              <tr>
                <td colspan="4"><div style="border:#000 1px solid"></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Jumlah</td>
                <td>:</td>
                <td colspan="2"><?=$data['jumlah']?> ml</td>
                </tr>
              </table></td>
            <td scope="col"><table width="300">
              <tr>
                <td colspan="4"><strong>Tranfusi darah</strong></td>
                </tr>
              <tr>
                <td colspan="4">Jenis : <?=$data['jenis_transfusi']?> cc</td>
                </tr>
              <tr>
                <td colspan="4">Jumlah                             : <?=$data['jumlah_transfusi']?> Kantong</td>
                </tr>
              <tr>
                <td colspan="3">Golongan darah :
                  <?=$gol_darah;?></td>
                <td width="106">&nbsp;</td>
                </tr>
              <tr>
                <td>No Seri :</td>
                <td width="6">&nbsp;</td>
                <td width="40">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="4">1. <?=$data['no_seri1']?></td>
                </tr>
              <tr>
                <td colspan="4">2.                  
                  <?=$data['no_seri2']?></td>
                </tr>
              <tr>
                <td colspan="4">3.                  
                  <?=$data['no_seri3']?></td>
                </tr>
              </table></td>
            <td scope="col"><table width="300">
              <tr>
                <td colspan="5"><strong>Pemeriksaan penunjang</strong></td>
                </tr>
              <tr>
                <td width="89">Laboratorium </td>
                <td width="9">:</td>
                <td colspan="3"><?=$data['laboratorium']?></td>
                </tr>
              <tr>
                <td colspan="5">&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="135">&nbsp;</td>
                <td width="21">&nbsp;</td>
                <td width="22">&nbsp;</td>
                </tr>
              <tr>
                <td>Foto thorax</td>
                <td> :</td>
                <td colspan="3"><?=$data['foto_thorax']?></td>
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
              <tr>
                <td>EKG </td>
                <td>:</td>
                <td colspan="3"><?=$data['ekg']?></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><div align="center"><strong>M O N I T O R I N G</strong></div></td>
        </tr>
      <tr>
        <td><div id="intable"><table border="1" align="center" class="tanggal" id="datatable" style="border-collapse:collapse">
          <tr bgcolor="#ababab">
            <td colspan="14" align="right" valign="middle" bgcolor="#0099FF">&nbsp;</td>
            </tr>
          <tr bgcolor="#0099FF">
            <td align="center" bgcolor="#33CCFF">Jam</td>
            <td align="center" bgcolor="#33CCFF">TD</td>
            <td align="center" bgcolor="#33CCFF">Nadi</td>
            <td align="center" bgcolor="#33CCFF">RR</td>
            <td align="center" bgcolor="#33CCFF">Suhu</td>
            <td align="center" bgcolor="#33CCFF">QB</td>
            <td align="center" bgcolor="#33CCFF">UF Goal</td>
            <td align="center" bgcolor="#33CCFF">UFR</td>
            <td align="center" bgcolor="#33CCFF">UF</td>
            <td align="center" bgcolor="#33CCFF">Tek Vena</td>
            <td align="center" bgcolor="#33CCFF">TMP</td>
            <td align="center" bgcolor="#33CCFF">Heparin</td>
            <td align="center" bgcolor="#33CCFF">Keterangan</td> 
            </tr>
             <?
					$sql2="select * from b_ms_hemodialisis_detail where id_hemodialisis ='$id'";	
					$query=mysql_query($sql2);
					while($data2=mysql_fetch_object($query)){
						?>
          <tr>
            <td width="100"><center><?=$data2->t_jam;?></center></td>
            <td width="50"><?=$data2->t_td;?></td>
            <td width="50"><?=$data2->t_nadi;?></td>
            <td width="50"><?=$data2->t_rr;?></td>
            <td width="50"><?=$data2->t_suhu;?></td>
            <td width="50"><?=$data2->t_qb;?></td>
            <td width="50"><?=$data2->t_ufg;?></td>
            <td width="50"><?=$data2->t_ufr;?></td>
            <td width="50"><?=$data2->t_uf;?></td>
            <td width="50"><?=$data2->t_tekvena;?></td>
            <td width="50"><?=$data2->t_tmp;?></td>
            <td width="50"><?=$data2->t_heparin;?></td>
            <td width="200"><?=$data2->t_keterangan;?></td>
            </tr>
            <?
				}
			?>
          </table></div></td>
        </tr>
      <tr>
        <td><table width="900">
          <tr>
            <td width="450" scope="col"><table width="450">
              <tr>
                <td colspan="2" scope="col"><strong>Obat yang diberikan</strong></td>
                </tr>
              <tr>
                <td width="21"><input type="checkbox" name="check[42]" id="check[]" value="42" /></td>
                <td width="417">Hemapo</td>
                </tr>
              <tr>
                <td><input type="checkbox" name="check[43]" id="check[]" value="43" /></td>
                <td>Eprex</td>
                </tr>
              <tr>
                <td><input type="checkbox" name="check[44]" id="check[]" value="44" /></td>
                <td>Recormen</td>
                </tr>
              <tr>
                <td><input type="checkbox" name="check[45]" id="check[]" value="45" /></td>
                <td>Extrace</td>
                </tr>
              <tr>
                <td><input type="checkbox" name="check[46]" id="check[]" value="46" /></td>
                <td>Neurobion</td>
                </tr>
              <tr>
                <td><input type="checkbox" name="check[47]" id="check[]" value="47" /></td>
                <td>Metycobalamin</td>
                </tr>
              </table></td>
            <td scope="col"><table width="450">
              <tr>
                <td width="450" scope="col">Jam pemberian : 
                  <?=$data['jam_pemberian']?></td>
                <td scope="col">&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td width="450">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td><table width="900" border="1" style="border-collapse:collapse">
          <tr>
            <td width="450" scope="col"><strong>Pemeriksaan setelah Dialisis</strong><br />
              <em>On Discharge</em></td>
            <td width="450" scope="col"><strong> Pukul</strong> : 
              <?=$data['jam_setelah']?>
              <br />
              <em> Time</em></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="900" border="1" style="border-collapse:collapse">
          <tr>
            <td width="650" scope="col"><p><strong>Kondisi :</strong></p>
              <p>
                <?=$data['kondisi_setelah']?>
                <br />
              </p></td>
            <td scope="col"><table width="250">
              <tr>
                <td width="78" scope="col">TD</td>
                <td width="19" scope="col">:</td>
                <td width="71" scope="col"><?=$data['td_setelah']?></td>
                <td width="57" scope="col">RR</td>
                <td width="10" scope="col">:</td>
                <td width="155" scope="col"><?=$data['rr_setelah']?></td>
              </tr>
              <tr>
                <td>Nadi</td>
                <td>:</td>
                <td><?=$data['nadi_setelah']?></td>
                <td>Suhu</td>
                <td>:</td>
                <td><?=$data['suhu_setelah']?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td><div align="center">D I S I&nbsp;&nbsp; J I K A &nbsp;&nbsp;P A S I E N&nbsp;&nbsp; P U L A N G</div></td>
        </tr>
      <tr>
        <td><table width="900" border="1" style="border-collapse:collapse">
          <tr>
            <td width="450" scope="col"><strong>Catatan untuk hemodialisis selanjutnya</strong></td>
            <td width="450" scope="col"><strong>Hemodialisis Selanjutnya</strong></td>
            </tr>
          <tr>
            <td width="450" scope="col"><?=$data['catatan_hemodialisis1']?></td>
            <td width="450" scope="col">Hari &nbsp;&nbsp;: 
              <?=$data['tgl_selanjutnya']?></td>
            </tr>
          <tr>
            <td width="450" scope="col"><?=$data['catatan_hemodialisis2']?></td>
            <td width="450" scope="col">Pukul :  
              <?=$data['jam_selanjutnya']?></td>
            </tr>
          <tr>
            <td width="450" scope="col"><strong>Perawat yang bertugas: <?=$dP['dr_rujuk']?></strong><br />Paraf</td>
            <td width="450" scope="col"><strong>Dokter : 
            <?
			$sqld="SELECT bpeg.`nama` FROM `b_ms_pegawai` bpeg LEFT JOIN `b_pelayanan` bpel ON bpel.`dokter_id`=bpeg.`id` WHERE bpel.`id`='$idPel'";
			$dok=mysql_fetch_array(mysql_query($sqld));
			echo $dok['nama'];
			?></strong>
            <br />Paraf</td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="900" border="1" style="border-collapse:collapse">
      <tr>
        <td colspan="2" scope="col"><div align="center"><strong>TRAVELING HEMODIALISIS<BR />RS PELINDO I</strong></div></td>
        </tr>
      <tr>
        <td><table width="450">
          <tr>
            <td scope="col"><strong>Diagnosa : 
              <?=$diag;?>
            </strong></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td><table width="450">
          <tr>
            <td width="98" scope="col"><strong>Nama</strong></td>
            <td width="13" scope="col"><strong>:</strong></td>
            <td width="323" scope="col"><?=$nama;?></td>
          </tr>
          <tr>
            <td><strong>RM</strong></td>
            <td><strong>:</strong></td>
            <td><?=$noRM;?></td>
          </tr>
          <tr>
            <td><strong>Tgl.lahir</strong></td>
            <td><strong>:</strong></td>
            <td><?=$tgl;?></td>
          </tr>
          <tr>
            <td><strong>Jenis kelamin</strong></td>
            <td><strong>:</strong></td>
            <td><?=$sex;?></td>
          </tr>
          <tr>
            <td><strong>Alamat</strong></td>
            <td><strong>:</strong></td>
            <td><?=$alamat;?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><strong>Terapi :</strong><br />
          <label for="terapi"></label>
          <?=$data['terapi']?><br /></td>
        <td><strong>Alergi : </strong><br /><?php 
			//echo $dP['id'];
				$sqlA="SELECT * from b_riwayat_alergi
				WHERE pasien_id='188';";//".$dP['id']."
				$exA=mysql_query($sqlA);
				while($dA=mysql_fetch_array($exA)){?>
              <?=$dA['riwayat_alergi'].'<br>';
					$pantangan = $dA['riwayat_alergi'];
					?>
              
              <?php }?></td>
      </tr>
      <tr>
        <td colspan="2"><table width="900">
          <tr>
            <td width="169" scope="col">Berat kering</td>
            <td width="10" scope="col">:</td>
            <td width="705" scope="col"><?=$bb;?> Kg</td>
          </tr>
          <tr>
            <td>Golongan darah</td>
            <td>:</td>
            <td><?=$gol_darah;?></td>
          </tr>
          <tr>
            <td>Hemodialisis pertama</td>
            <td>:</td>
            <td><?=$data['hemodialisis_pertama']?></td>
          </tr>
          <tr>
            <td>Hemodialisis terakhir</td>
            <td>:</td>
            <td><?=$data['hemodialisis_terakhir']?></td>
          </tr>
          <tr>
            <td>Dializer</td>
            <td>:</td>
            <td><?=$data['dializer']?></td>
          </tr>
          <tr>
            <td>Jenis dialisat</td>
            <td>:</td>
            <td><?=$data['jenis_dialisat']?></td>
          </tr>
          <tr>
            <td>Lamanya dialisis</td>
            <td>:</td>
            <td><?=$data['lama_dialisis']?></td>
          </tr>
          <tr>
            <td>Kecepatan aliran darah</td>
            <td>:</td>
            <td><?=$data['kecepatan_darah']?></td>
          </tr>
          <tr>
            <td>Akses vaskuler</td>
            <td>:</td>
            <td><?=$data['akses_vaskuler']?></td>
          </tr>
          <tr>
            <td>Heparinisasi dosis awal</td>
            <td>:</td>
            <td><?=$data['heparinisasi']?></td>
          </tr>
          <tr>
            <td>Tekana darah</td>
            <td>:</td>
            <td><?=$tensi?></td>
          </tr>
          <tr>
            <td>Transfusi terakhir</td>
            <td>:</td>
            <td><?=$data['transfusi_terakhir']?></td>
          </tr>
          <tr>
            <td>Hasil lab. terakhir</td>
            <td>:</td>
            <td><?=$data['lab_terakhir']?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td><table width="450">
          <tr>
            <td width="77" scope="col">Tanggal</td>
            <td width="10" scope="col">:</td>
            <td width="347" scope="col"><?=tglSQL($data['tgl_traveling'])?></td>
            </tr>
          <tr>
            <td>Hb</td>
            <td>:</td>
            <td><?=$data['hb_traveling']?></td>
            </tr>
          <tr>
            <td>Ureum</td>
            <td>:</td>
            <td><?=$data['ureum_traveling']?></td>
            </tr>
          <tr>
            <td>HIV</td>
            <td>:</td>
            <td><?=$data['hiv_traveling']?></td>
            </tr>
          </table></td>
        <td><table width="450">
          <tr>
            <td width="77" scope="col">GDS</td>
            <td width="10" scope="col">:</td>
            <td width="347" scope="col"><?=$data['gds_traveling']?></td>
            </tr>
          <tr>
            <td>Creatinin</td>
            <td>:</td>
            <td><?=$data['creatinin_traveling']?></td>
            </tr>
          <tr>
            <td>HbsAg</td>
            <td>:</td>
            <td><?=$data['hbs_traveling']?></td>
            </tr>
          <tr>
            <td>HCV</td>
            <td>:</td>
            <td><?=$data['hcv_traveling']?></td>
            </tr>
          </table></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="5">Catatan :      </td>
  </tr>
  <tr>
    <td colspan="5"><?=$data['catatan']?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Medan, <?=tgl_ina(date('Y-m-d'));?> </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Dokter Pelaksana Hemodialisis</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td class="noline"	 align="center" colspan="11">     
           <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
          <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
   </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center">
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
<td>&nbsp;</td>
                </tr>
               
               
  </table>
</div>
</body>
<script type="text/javascript">

function cetak(tombol){
	tombol.style.visibility='collapse';
	if(tombol.style.visibility=='collapse'){
		if(confirm('Anda Yakin Mau Mencetak ?')){
			setTimeout('window.print()','1000');
			setTimeout('window.close()','2000');
		}
		else{
			tombol.style.visibility='visible';
		}

	}
}

function cek(){
	var x = '<?=$data['checked']?>';
	var val=x.split(',');
	//alert(val[5]);
	var list1 = document.form1.elements['check[]'];
	if ( list1.length > 0 )
	{
	 for (i = 0; i < list1.length; i++)
		{
		  if (list1[i].value==val[i])
		  {
		   list1[i].checked = true;
		  }else{
				list1[i].checked = false;
				}
	  }
	}
}


function checked_off(){
	var list1 = document.form1.elements['check[]'];
	if ( list1.length > 0 ){
		for (i = 0; i < list1.length; i++){
		   list1[i].disabled = true;  
	  	}
	}
}
</script>

</html>

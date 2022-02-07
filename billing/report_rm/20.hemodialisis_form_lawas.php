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

<body onload="tanggalan();jam();">
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
<div id="tampil_input" align="center" style="display:none">
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
            <td>Tanggal&nbsp;<input type='text' class="tgl" name='tanggal1' id='tanggal1'> </td>
            <td>Pukul&nbsp;<input type='text' class="jam" name="pukul1" id="pukul1"></td>
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
                <td><label for="riwayat"></label>
                  <textarea name="riwayat" id="riwayat" cols="45" rows="5"></textarea></td>
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
                <td>BMI : 
                  <input name="bmi" type="text" id="bmi" size="3"  /> 
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
                <td colspan="3"><label for="mata"></label>
                  <input type="text" name="mata" id="mata" /></td>
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
                        <input type="checkbox" name="check[6]" id="check[]" class="skala_nyeri" value="6"/></td>
                      <td width="50">1
                        <input type="checkbox" name="check[7]" id="check[]" class="skala_nyeri" value="7"/></td>
                      <td width="50">2
                        <input type="checkbox" name="check[8]" id="check[]" class="skala_nyeri" value="8"/></td>
                      <td width="50">3
                        <input type="checkbox" name="check[9]" id="check[]" class="skala_nyeri" value="9"/></td>
                      <td width="50">4
                        <input type="checkbox" name="check[10]" id="check[]" class="skala_nyeri" value="10"/></td>
                      <td width="50">5
                        <input type="checkbox" name="check[11]" id="check[]" class="skala_nyeri" /></td>
                      <td width="50">6
                        <input type="checkbox" name="check[12]" id="check[]" class="skala_nyeri" value="12"/></td>
                      <td width="50">7
                        <input type="checkbox" name="check[13]" id="check[]" class="skala_nyeri" value="13"/></td>
                      <td width="50">8
                        <input type="checkbox" name="check[14]" id="check[]" class="skala_nyeri" value="14" /></td>
                      <td width="50">9
                        <input type="checkbox" name="check[15]" id="check[]" class="skala_nyeri" value="15" /></td>
                      <td width="50">10
                        <input type="checkbox" name="check[16]" id="check[]" class="skala_nyeri" value="16" /></td>
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
                <td width="117">BB Pre HD  
                  <label for="bb_pre_hd"></label>
                  <input name="bb_pre_hd" type="text" id="bb_pre_hd" size="3"  /></td>
                <td width="79">  Kg</td>
                <td width="19">&nbsp;</td>
                <td width="115">BB Post HD 
                  <input name="bb_post_hd" type="text" id="bb_post_hd" size="3"  /></td>
                <td width="96"> Kg</td>
                </tr>
              <tr>
                <td colspan="2">Intradialek Weight Gain 
                  <input name="iwg" type="text" id="iwg" size="3" />
                  Kg </td>
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
                <td width="75"><input name="lama" type="text" id="lama" size="5" /></td>
                <td>Jam</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>QB</td>
                <td>:</td>
                <td><input name="qb_program" type="text" id="qb_program" size="5" /></td>
                <td>mil/jam</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>QD</td>
                <td>:</td>
                <td><input name="qd_program" type="text" id="qd_program" size="5" /></td>
                <td>mil/jam</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>UF Goal</td>
                <td>:</td>
                <td><input name="ufg_program" type="text" id="ufg_program" size="5" /></td>
                <td>L</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>Haparin</td>
                <td>:</td>
                <td><input type="checkbox" name="check[17]" id="check[]" value="17" /> 
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
                <td><input name="dosis_awal" type="text" id="dosis_awal" size="5" />  
                  U</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="check[19]" id="check[]" value="19"/> 
                  Free</td>
                <td>&nbsp;</td>
                <td>Maintenance</td>
                <td>:</td>
                <td><input name="maintenance" type="text" id="maintenance" size="5" /> 
                  U</td>
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
            <td width="126">Mesin No : 
              <input name="mesin_no" type="text" id="mesin_no" size="5" /></td>
            <td width="152">Jenis Dialiser :
              <input name="jenis_dialiser" type="text" id="jenis_dialiser" size="5" /></td>
            <td width="71"><input type="checkbox" name="check[20]" id="check[]" value="20"/> 
              New</td>
            <td><input type="checkbox" name="check[21]" id="check[]" value="21" />
              Rouse</td>
            <td>Tipe Dialiser</td>
            <td><input name="tipe_dialiser" type="text" id="tipe_dialiser" size="5" /></td>
            <td>&nbsp;</td>
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
                <td colspan="5" scope="col"><strong>Pengawasan cairan selama HD</strong></td>
                </tr>
              <tr>
                <td width="19">1.</td>
                <td width="91">Volume priming</td>
                <td width="11">:</td>
                <td width="68"><input name="volume_priming" type="text" id="volume_priming" size="5" /></td>
                <td width="87">ml</td>
                </tr>
              <tr>
                <td>2.</td>
                <td>Cairan keluar</td>
                <td>:</td>
                <td><input name="cairan_keluar" type="text" id="cairan_keluar" size="5" /></td>
                <td>ml</td>
                </tr>
              <tr>
                <td>3.</td>
                <td>Sisa priming</td>
                <td>:</td>
                <td><input name="sisa_priming" type="text" id="sisa_priming" size="5" /></td>
                <td>ml</td>
                </tr>
              <tr>
                <td>4.</td>
                <td>Cairan drip</td>
                <td>:</td>
                <td><input name="cairan_drip" type="text" id="cairan_drip" size="5" /></td>
                <td>ml</td>
                </tr>
              <tr>
                <td>5.</td>
                <td>Darah</td>
                <td>:</td>
                <td><input name="darah" type="text" id="darah" size="5" /></td>
                <td>ml</td>
                </tr>
              <tr>
                <td>6.</td>
                <td>Wash Out</td>
                <td>:</td>
                <td><input name="wash_out" type="text" id="wash_out" size="5" /></td>
                <td>ml</td>
                </tr>
              <tr>
                <td colspan="5"><!--<div style="border:#000 1px solid"></div>--></td>
                </tr>
              <!--<tr>
                <td>&nbsp;</td>
                <td>Jumlah</td>
                <td>:</td>
                <td><input name="jumlah" type="text" id="jumlah" size="5" /></td>
                <td>ml</td>
                </tr>-->
              </table></td>
            <td scope="col"><table width="300">
              <tr>
                <td colspan="5"><strong>Tranfusi darah</strong></td>
                </tr>
              <tr>
                <td width="17">Jenis</td>
                <td width="49"><input name="jenis_transfusi" type="text" id="jenis_transfusi" size="5" /></td>
                <td width="6">:</td>
                <td width="40">&nbsp;</td>
                <td width="106">cc</td>
                </tr>
              <tr>
                <td>Jumlah</td>
                <td><input name="jumlah_transfusi" type="text" id="jumlah_transfusi" size="5" /></td>
                <td>:</td>
                <td>&nbsp;</td>
                <td>Kantong</td>
                </tr>
              <tr>
                <td colspan="2">Golongan darah</td>
                <td>:</td>
                <td><?=$gol_darah;?></td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>No Seri</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="4">1. 
                  <input name="no_seri1" type="text" id="no_seri1" size="20" /></td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="4">2. 
                  <input name="no_seri2" type="text" id="no_seri2" size="20" /></td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td colspan="4">3. 
                  <input name="no_seri3" type="text" id="no_seri3" size="20" /></td>
                <td>&nbsp;</td>
                </tr>
              </table></td>
            <td scope="col"><table width="300">
              <tr>
                <td colspan="5"><strong>Pemeriksaan penunjang</strong></td>
                </tr>
              <tr>
                <td width="89">Laboratorium </td>
                <td width="9">:</td>
                <td colspan="3"><input name="laboratorium" type="text" id="laboratorium" size="25" /></td>
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
                <td colspan="3"><input name="foto_thorax" type="text" id="foto_thorax" size="25" /></td>
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
                <td colspan="3"><input name="ekg" type="text" id="ekg" size="25" /></td>
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
            <td colspan="14" align="right" valign="middle" bgcolor="#0099FF"><input type="button" value="Tambah" onclick="tambahrow()" /></td>
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
            <td align="center" bgcolor="#33CCFF">&nbsp;</td>
            </tr>
          <tr>
            <td><input type='text' class="jam" name="jam[]" id="jam0"></td>
            <td><input type='text' name='td[]' id='td0' size="3"></td>
            <td><input type='text' name='nadi[]' id='nadi0' size="3"></td>
            <td><input type='text' name='rr[]' id='rr0' size="3"></td>
            <td><input type='text' name='suhu[]' id='suhu0' size="3"></td>
            <td><input type='text' name='qb[]' id='qb0' size="3"></td>
            <td><input type='text' name='ufg[]' id='ufg0' size="3"></td>
            <td><input type='text' name='ufr[]' id='ufr0' size="3"></td>
            <td><input type='text' name='uf[]' id='uf0' size="3"></td>
            <td><input type='text' name='tek[]' id='tek0' size="3"></td>
            <td><input type='text' name='tmp[]' id='tmp0' size="3"></td>
            <td><input type='text' name='heparin[]' id='heparin0' size="3"></td>
            <td><input type='text' name='keterangan[]' id='keterangan0' size="25"></td>
            <td><!--<input type='button' value='Delete' onclick='del(this)' />-->
              <img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick="del(this)" /></td>
            </tr>
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
                <td width="450" scope="col">Jam pemberian : <input type='text' class="jam" name="jam_pemberian" id="jam_pemberian"></td>
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
              <input type='text' class="jam" name="jam_setelah" id="jam_setelah"><br />
              <em> Time</em></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="900" border="1" style="border-collapse:collapse">
          <tr>
            <td width="650" scope="col"><p><strong>Kondisi :</strong></p>
              <p>
                <textarea name="kondisi_setelah" id="kondisi_setelah" cols="70" rows="2"></textarea>
                <br />
              </p></td>
            <td scope="col"><table width="250">
              <tr>
                <td width="78" scope="col">TD</td>
                <td width="19" scope="col">:</td>
                <td width="71" scope="col"><input name="td_setelah" type="text" id="td_setelah" size="5" /></td>
                <td width="57" scope="col">RR</td>
                <td width="10" scope="col">:</td>
                <td width="155" scope="col"><input name="rr_setelah" type="text" id="rr_setelah" size="5" /></td>
              </tr>
              <tr>
                <td>Nadi</td>
                <td>:</td>
                <td><input name="nadi_setelah" type="text" id="nadi_setelah" size="5" /></td>
                <td>Suhu</td>
                <td>:</td>
                <td><input name="suhu_setelah" type="text" id="suhu_setelah" size="5" /></td>
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
            <td width="450" scope="col"><input name="catatan_hemodialisis1" type="text" id="catatan_hemodialisis1" size="70" /></td>
            <td width="450" scope="col">Hari &nbsp;&nbsp;: <input type='text' class="tgl" name='tgl_selanjutnya' id='tgl_selanjutnya'></td>
            </tr>
          <tr>
            <td width="450" scope="col"><input name="catatan_hemodialisis2" type="text" id="catatan_hemodialisis2" size="70" /></td>
            <td width="450" scope="col">Pukul :  <input type='text' class="jam" name="jam_selanjutnya" id="jam_selanjutnya"></td>
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
          <textarea name="terapi" id="terapi" cols="70" rows="1"></textarea>          <br /></td>
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
            <td><input name="hemodialisis_pertama" type="text" id="hemodialisis_pertama" size="50" /></td>
          </tr>
          <tr>
            <td>Hemodialisis terakhir</td>
            <td>:</td>
            <td><input name="hemodialisis_terakhir" type="text" id="hemodialisis_terakhir" size="50" /></td>
          </tr>
          <tr>
            <td>Dializer</td>
            <td>:</td>
            <td><input name="dializer" type="text" id="dializer" size="50" /></td>
          </tr>
          <tr>
            <td>Jenis dialisat</td>
            <td>:</td>
            <td><input name="jenis_dialisat" type="text" id="jenis_dialisat" size="50" /></td>
          </tr>
          <tr>
            <td>Lamanya dialisis</td>
            <td>:</td>
            <td><input name="lama_dialisis" type="text" id="lama_dialisis" size="20" /></td>
          </tr>
          <tr>
            <td>Kecepatan aliran darah</td>
            <td>:</td>
            <td><input name="kecepatan_darah" type="text" id="kecepatan_darah" size="20" /></td>
          </tr>
          <tr>
            <td>Akses vaskuler</td>
            <td>:</td>
            <td><input name="akses_vaskuler" type="text" id="akses_vaskuler" size="20" /></td>
          </tr>
          <tr>
            <td>Heparinisasi dosis awal</td>
            <td>:</td>
            <td><input name="heparinisasi" type="text" id="heparinisasi" size="20" /></td>
          </tr>
          <tr>
            <td>Tekana darah</td>
            <td>:</td>
            <td><?=$tensi?></td>
          </tr>
          <tr>
            <td>Transfusi terakhir</td>
            <td>:</td>
            <td><input name="transfusi_terakhir" type="text" id="transfusi_terakhir" size="20" /></td>
          </tr>
          <tr>
            <td>Hasil lab. terakhir</td>
            <td>:</td>
            <td><input name="lab_terakhir" type="text" id="lab_terakhir" size="20" /></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td><table width="450">
          <tr>
            <td width="77" scope="col">Tanggal</td>
            <td width="10" scope="col">:</td>
            <td width="347" scope="col"><input type='text' class="tgl" name='tgl_traveling' id='tgl_traveling'></td>
            </tr>
          <tr>
            <td>Hb</td>
            <td>:</td>
            <td><input name="hb_traveling" type="text" id="hb_traveling" size="20" /></td>
            </tr>
          <tr>
            <td>Ureum</td>
            <td>:</td>
            <td><input name="ureum_traveling" type="text" id="ureum_traveling" size="20" /></td>
            </tr>
          <tr>
            <td>HIV</td>
            <td>:</td>
            <td><input name="hiv_traveling" type="text" id="hiv_traveling" size="20" /></td>
            </tr>
          </table></td>
        <td><table width="450">
          <tr>
            <td width="77" scope="col">GDS</td>
            <td width="10" scope="col">:</td>
            <td width="347" scope="col"><input name="gds_traveling" type="text" id="gds_traveling" size="20" /></td>
            </tr>
          <tr>
            <td>Creatinin</td>
            <td>:</td>
            <td><input name="creatinin_traveling" type="text" id="creatinin_traveling" size="20" /></td>
            </tr>
          <tr>
            <td>HbsAg</td>
            <td>:</td>
            <td><input name="hbs_traveling" type="text" id="hbs_traveling" size="20" /></td>
            </tr>
          <tr>
            <td>HCV</td>
            <td>:</td>
            <td><input name="hcv_traveling" type="text" id="hcv_traveling" size="20" /></td>
            </tr>
          </table></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="5">Catatan :      </td>
  </tr>
  <tr>
    <td colspan="5"><textarea name="catatan" id="catatan" cols="70" rows="2"></textarea></td>
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
    <td colspan="5" align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
      <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></td>
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
                    <td colspan="2"><?php
                    if($_REQUEST['report']!=1){
					?>
                      <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>                    <?php }?></td>
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
                  <td colspan="5"></td>
                </tr>
  </table>
</div>
</body>
<script type="text/javascript">

function toggle() {
 //parent.alertsize(document.body.scrollHeight);
}

function simpan(action){
	if(ValidateForm('tanggal1,pukul1')){
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
        
var a=new DSGridObject("gridbox");
a.setHeader("Data Hemodialisis");
a.setColHeader("NO,NO RM,NAMA,TGL INPUT,PENGGUNA");
a.setIDColHeader(",no_rm,nama,tgl_act,nama_user");
a.setColWidth("50,150,400,100,200");
a.setCellAlign("center,center,center,center,center");
a.setCellHeight(20);
a.setImgPath("../icon");
a.setIDPaging("paging");
a.attachEvent("onRowClick","ambilData");
//a.onLoaded(konfirmasi);
a.baseURL("20.hemodialisis_util.php?idPel=<?=$idPel?>");
a.Init();
		
function goFilterAndSort(grd){
	a.loadURL("20.hemodialisis_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
}		
		
function hapus(){
	var id = document.getElementById("txtId").value;
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
	var id = document.getElementById("txtId").value;
	//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
	if(id==''){
			alert("Pilih data terlebih dahulu");
		}else{
			$('#act').val('edit');
			$('#tampil_input').slideDown(1000,function(){
toggle();
});
		}

}

function batal(){
	resetF();
	$('#tampil_input').slideUp(1000,function(){
toggle();
});
}       

function resetF(){
	$('#act').val('tambah');
	document.getElementById('form1').reset();
	//$('#id').val('');
	//$('#txt_anjuran').val('');
	$('#inObat').load("14.form_terapi_pulang.php");
	$('#inObat2').load("14.form_kembali_kontrol.php");
	//centang(1,'L')
}       

function tambah(){
	resetF();
	$('#tampil_input').slideDown(1000,function(){
		toggle();
	});
}       

function tambahrow(){
	var idx2 = $('#datatable tr').length;
	var idx = idx2-1;
    var x=document.getElementById('datatable').insertRow(idx+1);
    var td1=x.insertCell(0);
    var td2=x.insertCell(1);
    var td3=x.insertCell(2);
    var td4=x.insertCell(3);
	var td5=x.insertCell(4);
	var td6=x.insertCell(5);
    var td7=x.insertCell(6);
    var td8=x.insertCell(7);
    var td9=x.insertCell(8);
	var td10=x.insertCell(9);
	var td11=x.insertCell(10);
    var td12=x.insertCell(11);
    var td13=x.insertCell(12);
    var td14=x.insertCell(13);
	
	td1.innerHTML="<input type='text' class='jam' name='jam[]' id='jam"+idx+"'>";jam();
  	td2.innerHTML="<input type='text' name='td[]' id='td"+idx+"' size='3'>";
	td3.innerHTML="<input type='text' name='nadi[]' id='nadi"+idx+"' size='3'>";
	td4.innerHTML="<input type='text' name='rr[]' id='rr"+idx+"' size='3'>";
	td5.innerHTML="<input type='text' name='suhu[]' id='suhu"+idx+"' size='3'>";
	td6.innerHTML="<input type='text' name='qb[]' id='qb"+idx+"' size='3'>";
	td7.innerHTML="<input type='text' name='ufg[]' id='ufg"+idx+"' size='3'>";
	td8.innerHTML="<input type='text' name='ufr[]' id='ufr"+idx+"' size='3'>";
	td9.innerHTML="<input type='text' name='uf[]' id='uf"+idx+"' size='3'>";
	td10.innerHTML="<input type='text' name='tek[]' id='tek"+idx+"' size='3'>";
	td11.innerHTML="<input type='text' name='tmp[]' id='tmp"+idx+"' size='3'>";
	td12.innerHTML="<input type='text' name='heparin[]' id='heparin"+idx+"' size='3'>";
	td13.innerHTML="<input type='text' name='keterangan[]' id='keterangan"+idx+"' size='25'>";
	td14.innerHTML='<img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onclick=del(this) />';
}

function del(elm){
	var idx = $(elm).parents('#datatable tr').prevAll().length;
		//alert(idrow);
	var x=document.getElementById('datatable').deleteRow(idx);
}

function ambilData(){					
	var sisip = a.getRowId(a.getSelRow()).split('|');
	$('#txtId').val(sisip[0]);
	$('#tanggal1').val(sisip[2]);
	$('#pukul1').val(sisip[3]);
	$('#riwayat').val(sisip[4]);
	$('#bmi').val(sisip[5]);
	$('#mata').val(sisip[6]);
	$('#bb_pre_hd').val(sisip[7]);
	$('#bb_post_hd').val(sisip[8]);
	$('#iwg').val(sisip[9]);
	$('#lama').val(sisip[10]);
	$('#qb_program').val(sisip[11]);
	$('#qd_program').val(sisip[12]);
	$('#ufg_program').val(sisip[13]);
	$('#dosis_awal').val(sisip[14]);
	$('#maintenance').val(sisip[15]);
	$('#mesin_no').val(sisip[16]);
	$('#jenis_dialiser').val(sisip[17]);
	$('#tipe_dialiser').val(sisip[18]);
	$('#volume_priming').val(sisip[19]);
	$('#cairan_keluar').val(sisip[20]);
	$('#sisa_priming').val(sisip[21]);
	$('#cairan_drip').val(sisip[22]);
	$('#darah').val(sisip[23]);
	$('#wash_out').val(sisip[24]);
	$('#jumlah').val(sisip[25]);
	$('#jenis_transfusi').val(sisip[26]);
	$('#jumlah_transfusi').val(sisip[27]);
	$('#no_seri1').val(sisip[28]);
	$('#no_seri2').val(sisip[29]);
	$('#no_seri3').val(sisip[30]);
	$('#laboratorium').val(sisip[31]);
	$('#foto_thorax').val(sisip[32]);
	$('#ekg').val(sisip[33]);
	$('#jam_pemberian').val(sisip[34]);
	$('#kondisi_setelah').val(sisip[35]);
	$('#jam_setelah').val(sisip[36]);
	$('#td_setelah').val(sisip[37]);
	$('#nadi_setelah').val(sisip[38]);
	$('#suhu_setelah').val(sisip[39]);
	$('#rr_setelah').val(sisip[40]);
	$('#catatan_hemodialisis1').val(sisip[41]);
	$('#catatan_hemodialisis2').val(sisip[42]);
	$('#tgl_selanjutnya').val(sisip[43]);
	$('#jam_selanjutnya').val(sisip[44]);
	$('#terapi').val(sisip[45]);
	$('#hemodialisis_pertama').val(sisip[46]);
	$('#hemodialisis_terakhir').val(sisip[47]);
	$('#dializer').val(sisip[48]);
	$('#jenis_dialisat').val(sisip[49]);
	$('#lama_dialisis').val(sisip[50]);
	$('#kecepatan_darah').val(sisip[51]);
	$('#akses_vaskuler').val(sisip[52]);
	$('#heparinisasi').val(sisip[53]);
	$('#transfusi_terakhir').val(sisip[54]);
	$('#lab_terakhir').val(sisip[55]);
	$('#tgl_traveling').val(sisip[56]);
	$('#hb_traveling').val(sisip[57]);
	$('#ureum_traveling').val(sisip[58]);
	$('#hiv_traveling').val(sisip[59]);
	$('#gds_traveling').val(sisip[60]);
	$('#creatinin_traveling').val(sisip[61]);
	$('#hbs_traveling').val(sisip[62]);
	$('#hcv_traveling').val(sisip[63]);
	$('#catatan').val(sisip[64]);
	
	//alert(sisip[1]);
	cek(sisip[1]);	 
	 
	$('#intable').load("20.tabel_hemodialisis.php?type=cek&id="+sisip[0]);
	
	//$('#fcf1').val(a.cellsGetValue(a.getSelRow(),2));
	  
	$('#act').val('edit');
}

function cek(tes){
	var val=tes.split(',');
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
window.open("20.hemodialisis_cetak.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUsr=<?=$idUsr?>","_blank");
		//}
}

$(function(){
	$('.skala_nyeri').click(function(){
		$('.skala_nyeri').removeAttr('checked');
		$(this).attr('checked', 'checked');
	});
});
</script>

</html>

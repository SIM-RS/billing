<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>

        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
    <!-- untuk ajax-->
    <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
    
<script type="text/javascript" src="js/jquery.timeentry.js"></script>
<script type="text/javascript">
$(function () 
{
	$('#jam').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam2').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam3').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam4').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam5').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam6').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam7').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam8').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam9').timeEntry({show24Hours: true, showSeconds: true});
	$('#jam10').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <title>.: PESANAN POST CATHETERISASI :.</title>
        <style>
        body{background:#FFF;}
        </style>
    </head>
<?php
	include "setting.php";
?>
    <body>
        <div align="center">
            <?php
           // include("../header1.php");
            ?>
        </div>

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
                    <td colspan="3" align="center"><div id="metu" style="display:none;">
                    <table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">: <?=$nama;?></td>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>: <?=$tgl;?></td>
        <td width="75">Usia</td>
        <td width="104">: <?=$umur;?> Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>: <?=$noRM;?></td>
        <td>No Registrasi </td>
        <td>: <?=$noreg;?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>: <?=$kamar;?> / <?=$kelas;?></td>
        <td colspan="2" rowspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td>Alamat</td>
        <td>: <?=$alamat;?></td>
        </tr>
    </table></td>
  </tr>
</table>
<br />
<span style="font:bold 18px tahoma;">PESANAN POST CATHETERISASI</span><br />
<form id="form1" name="form1" action="11.pesanan_pos_utils.php" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
                    <table width="800" border="1" cellpadding="4" bordercolor="#000000" style="font:12px tahoma; border-collapse:collapse;">
  <tr>
    <td><table width="800" border="0" cellpadding="4">
      <tr>
        <td width="39">&nbsp;</td>
        <td width="116">&nbsp;</td>
        <td width="613">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Tanggal</td>
        <td>: <input type="text" name="tgl" id="tgl" value="<?=date('d-m-Y')?>" style="width:70px;" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Dokter</td>
        <td>: <?=$dokter?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Diagnosa</td>
        <td>: <?php $sqlD="SELECT GROUP_CONCAT(md.nama) AS diag FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_fetch_array(mysql_query($sqlD));
echo $exD['diag'];
?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellpadding="4">
      <tr>
        <td width="37">&nbsp;</td>
        <td colspan="2"><b>Instruksi</b></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="19">1</td>
        <td width="712"> Periksa Tanda-tanda vital </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="617" border="1" bordercolor="#000000" style="border-collapse:collapse;">
          <tr>
            <td width="163">Post Tindakan</td>
            <td width="104" align="center">30 menit </td>
            <td width="101" align="center">1 jam </td>
            <td width="113" align="center">2 jam </td>
            <td width="102" align="center">3 jam </td>
          </tr>
          <tr>
            <td>a. Tensi </td>
            <td style="text-align:center"><input type="text" name="tensi1" id="tensi1" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="tensi2" id="tensi2" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="tensi3" id="tensi3" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="tensi4" id="tensi4" style="width:80px" /></td>
          </tr>
          <tr>
            <td>b. Nadi </td>
            <td style="text-align:center"><input type="text" name="nadi1" id="nadi1" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="nadi2" id="nadi2" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="nadi3" id="nadi3" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="nadi4" id="nadi4" style="width:80px" /></td>
          </tr>
          <tr>
            <td>c. Suhu </td>
            <td style="text-align:center"><input type="text" name="suhu1" id="suhu1" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="suhu2" id="suhu2" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="suhu3" id="suhu3" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="suhu4" id="suhu4" style="width:80px" /></td>
          </tr>
          <tr>
            <td>d. RR </td>
            <td style="text-align:center"><input type="text" name="rr1" id="rr1" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="rr2" id="rr2" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="rr3" id="rr3" style="width:80px" /></td>
            <td style="text-align:center"><input type="text" name="rr4" id="rr4" style="width:80px" /></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>2</td>
        <td>Buat rekaman EKG terbaru, tanggal <input type="text" name="tgl2" id="tgl2" value="<?=date('d-m-Y')?>" style="width:70px;" onclick="gfPop.fPopCalendar(document.getElementById('tgl2'),depRange);" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>3</td>
        <td>Infus <input type="text" name="infus" id="infus" style="width:200px" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>4</td>
        <td>Oksigen <input type="text" name="oksigen" id="oksigen" style="width:30px" />Liter</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>5</td>
        <td>Obat-obatan yang diberikan di ruang cath lab</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>a. <input type="text" name="obat1" id="obat1" style="width:250px" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>b. <input type="text" name="obat2" id="obat2" style="width:250px" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>c. <input type="text" name="obat3" id="obat3" style="width:250px" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>d. <input type="text" name="obat4" id="obat4" style="width:250px" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>

        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>a.</td>
        <td>Perawatan Post Tindakan Radial</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>*Dengan Nichiban / Radstat</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Nichiban / Radstat dilonggarkan jam <input type="text" name="jam" id="jam" style="width:50px" value="<?=date('H:i:s')?>"/></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- 1 jam kemudian jika tidak ada tanda-tanda perdarahan pada pergelangan tangan, nichiban/radstat</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Jika masih ada tanda-tanda perdarahan pada pergelangan tangan, nichiban/radstat direkatkan kembali seperti semula</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Pergelangan tangan kanan/kiri tidak boleh ditekuk sampai jam <input type="text" name="jam2" id="jam2" style="width:50px" value="<?=date('H:i:s')?>"/></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>*Dengan TR-Bank</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Udara di TR-Bank dikurangi 2 CC</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- 1 Jam kemudian TR-Band boleh dilepas</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Jika masih ada tanda-tanda perdarahan pada pergelangan tangan, udara yang dikeluarkan dari TR-Band dimasukkan kembali</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Pergelangan tangan kanan/kiri tidak boleh ditekuk sampai jam <input type="text" name="jam3" id="jam3" style="width:50px" value="<?=date('H:i:s')?>"/></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>

      <tr>
        <td width="37">&nbsp;</td>
        <td width="19">b.</td>
        <td width="712">Perawatan Post Tindakan dari Brachialis</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Siku tangan tidak boleh ditekuk sampai jam <input type="text" name="jam4" id="jam4" style="width:50px" value="<?=date('H:i:s')?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Elastis verband dilepas jam <input type="text" name="jam5" id="jam5" style="width:50px" value="<?=date('H:i:s')?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Untuk tindakan post PCI, cek ACT/PT/APTT jam <input type="text" name="jam6" id="jam6" style="width:50px" value="<?=date('H:i:s')?>"/> Bila hasil normal snealth boleh dilepas</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td>c.</td>
        <td>Perawatan Post Tindakan dari Femoral</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Kaki kanan / kiri tidak boleh ditekuk sampai jam <input type="text" name="jam7" id="jam7" style="width:50px" value="<?=date('H:i:s')?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Elastis Verban dilepas jam <input type="text" name="jam8" id="jam8" style="width:50px" value="<?=date('H:i:s')?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Pasien boleh mobilisasi pelan-pelan jam <input type="text" name="jam9" id="jam9" style="width:50px" value="<?=date('H:i:s')?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Periksa daerah inguinal kanan/kiri</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Periksa nadi dorsalis pedis kanan/ kiri</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Untuk tindakan post PCI, cek ACT/PT/APTT jam <input type="text" name="jam10" id="jam10" style="width:50px" value="<?=date('H:i:s')?>"/> Bila hasil normal snealth boleh dilepas</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>d.</td>
        <td>Pasien boleh langsung makan/minum setelah selesai tindakan.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><b><u>Perhatian</u></b></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>1.</td>
        <td>Bila terjadi perdarahan/ hematom dibekas luka tusuk tempat kateterisasi, tekan dengan tiga jari</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>dibagian proximalny selama 10-15 menit.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>2.</td>
        <td>Lapor ke dokter Operator/ Dokter jaga bila :&quot;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>a. Masih terus berdarah</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>b. Hypotensi</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>c. Bradycardia</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>d. Arythmia</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>e. Distress/ kesakitan</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>f. Febris/ menggigil</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>g. Sesak</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="622" border="0">
          <tr align="center">
            <td width="297">Petugas Cath-Lab</td>
            <td width="315">Penerima Pasien</td>
          </tr>
          <tr>
            <td height="73">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr align="center">
            <td>(<strong><u><?php echo $usr['nama'];?></u></strong>)</td>
            <td>(_____________________)</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
        <td colspan="10" class="noline" align="center">
                    <input name="simpen" id="simpen" type="button" value="Simpan" onclick="simpan(this.value);" class="tblTambah"/>
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input id="liaten" type="button" value="View" onClick="return liat()" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
                    <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
                </td>
        </tr>
</table>
</form>
                    </div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                    <select id="cmbUnit" name="cmbUnit" class="txtinput" onchange="alert('11.pesanan_pos_utils.php?grd=true&unit='+document.getElementById('cmbUnit').value);">
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

        //////////////////fungsi untuk tindakan////////////////////////
        function simpan(action)
        {
            /*if(ValidateForm('tajamlihat,mkanan,mkiri,anterior1,anterior2,posterior1,posterior2,wrn,catatan','ind'))
            {*/
                $("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					batal();
						a.loadURL("11.pesanan_pos_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
						//goFilterAndSort();
           /* }*/
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
		
		function cetak()
		{
			var rowid = document.getElementById("txtId").value;
			if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(id=='')
//			{
//				alert("Pilih data terlebih dahulu untuk di cetak");
//			}
//			else
//			{	
				window.open('11.pesanan_post.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
		//		document.getElementById('id').value="";
//			}
			//idKunj=11&idPel=20&idUser=732&inap=1&kelas_id=3
		}
		
        function ambilData()
        {
            var sisip=a.getRowId(a.getSelRow()).split("|");
            var p="txtId*-*"+sisip[0]+"*|*tgl*-*"+sisip[1]+"*|*tgl2*-*"+sisip[2]+"*|*jam*-*"+sisip[3]+"*|*jam2*-*"+sisip[4]+"*|*jam3*-*"+sisip[5]+"*|*jam4*-*"+sisip[6]+"*|*jam5*-*"+sisip[7]+"*|*jam6*-*"+sisip[8]+"*|*jam7*-*"+sisip[9]+"*|*jam8*-*"+sisip[10]+"*|*jam9*-*"+sisip[11]+"*|*jam10*-*"+sisip[12]+"*|*tensi1*-*"+sisip[13]+"*|*tensi2*-*"+sisip[14]+"*|*tensi3*-*"+sisip[15]+"*|*tensi4*-*"+sisip[16]+"*|*nadi1*-*"+sisip[17]+"*|*nadi2*-*"+sisip[18]+"*|*nadi3*-*"+sisip[19]+"*|*nadi4*-*"+sisip[20]+"*|*suhu1*-*"+sisip[21]+"*|*suhu2*-*"+sisip[22]+"*|*suhu3*-*"+sisip[23]+"*|*suhu4*-*"+sisip[24]+"*|*rr1*-*"+sisip[25]+"*|*rr2*-*"+sisip[26]+"*|*rr3*-*"+sisip[27]+"*|*rr4*-*"+sisip[28]+"*|*infus*-*"+sisip[29]+"*|*oksigen*-*"+sisip[30]+"*|*obat1*-*"+sisip[31]+"*|*obat2*-*"+sisip[32]+"*|*obat3*-*"+sisip[33]+"*|*obat4*-*"+sisip[34]+"";
            //alert(p);
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
            
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
			//var p="txtId*-**|*tgl*-**|*tgl2*-**|*jam*-**|*jam2*-**|*jam3*-**|*jam4*-**|*jam5*-**|*jam6*-**|*jam7*-**|*jam8*-**|*jam9*-**|*jam10*-**|*tensi1*-**|*tensi2*-**|*tensi3*-**|*tensi4*-**|*nadi1*-**|*nadi2*-**|*nadi3*-**|*nadi4*-**|*suhu1*-**|*suhu2*-**|*suhu3*-**|*suhu4*-**|*rr1*-**|*rr2*-**|*rr3*-**|*rr4*-**|*infus*-**|*oksigen*-**|*obat1*-**|*obat2*-**|*obat3*-**|*obat4*-*";
			var p="txtId*-**|*tensi1*-**|*tensi2*-**|*tensi3*-**|*tensi4*-**|*nadi1*-**|*nadi2*-**|*nadi3*-**|*nadi4*-**|*suhu1*-**|*suhu2*-**|*suhu3*-**|*suhu4*-**|*rr1*-**|*rr2*-**|*rr3*-**|*rr4*-**|*infus*-**|*oksigen*-**|*obat1*-**|*obat2*-**|*obat3*-**|*obat4*-*";
			fSetValue(window,p);
			$('#tgl').val('<?=date('d-m-Y')?>');
			$('#tgl2').val('<?=date('d-m-Y')?>');
			$('#jam').val('<?=date('H:i:s')?>');
			$('#jam2').val('<?=date('H:i:s')?>');
			$('#jam3').val('<?=date('H:i:s')?>');
			$('#jam4').val('<?=date('H:i:s')?>');
			$('#jam5').val('<?=date('H:i:s')?>');
			$('#jam6').val('<?=date('H:i:s')?>');
			$('#jam7').val('<?=date('H:i:s')?>');
			$('#jam8').val('<?=date('H:i:s')?>');
			$('#jam9').val('<?=date('H:i:s')?>');
			$('#jam10').val('<?=date('H:i:s')?>');
		}
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
                a.loadURL("11.pesanan_pos_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("PESANAN POST CATHETERISASI");
        a.setColHeader("NO,TANGGAL,DOKTER,DIAGNOSA");
        a.setIDColHeader(",tanggal,dokter,diag");
        a.setColWidth("30,80,200,200");
        a.setCellAlign("center,left,left,left");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("11.pesanan_pos_utils.php?grd=true"+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>");
        a.Init();
		
	
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>

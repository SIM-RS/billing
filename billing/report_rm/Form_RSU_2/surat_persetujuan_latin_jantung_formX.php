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

$que1="select *
from b_ms_pegawai
where id='$idUser'";
$usr=mysql_fetch_array(mysql_query($que1));
$que2="SELECT bp.nama
FROM b_pelayanan p
INNER JOIN b_ms_pasien bp ON p.pasien_id = bp.id
WHERE p.id='$idPel'";
$usr2=mysql_fetch_array(mysql_query($que2));

$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit, a.BB, a.TB, bk.no_reg, IF(p.alamat <> '',CONCAT(p.alamat,' RT. ',p.rt,' RW. ',p.rw, ' Desa ',bw.nama,' Kecamatan ',wi.nama),'-') AS almt_lengkap
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON pl.kunjungan_id = bk.id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
INNER JOIN b_ms_wilayah bw ON p.desa_id = bw.id
INNER JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN anamnese a ON a.PEL_ID=pl.id
WHERE pl.id='$idPel'";
$pasien=mysql_fetch_array(mysql_query($sqlP));

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
            <td width="174"><?php echo $pasien['nama'];?>&nbsp;/&nbsp;<span <?php if($pasien['sex']=='L'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($pasien['sex']=='P'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>P</span></td>
            </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><?php echo $pasien['tgllahir'];?>&nbsp;/ Usia: <?php echo $pasien['usia'];?>&nbsp;Th</td>
            </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><?php echo $pasien['no_rm'];?>&nbsp;No.Registrasi:&nbsp;<?=$pasien['no_reg']?></td>
            </tr>
          <tr>
            <td>Ruang Rawat / Kelas</td>
            <td>:</td>
            <td><?php echo $pasien['nm_unit'];?>&nbsp;/ <?php echo $pasien['nm_kls'];?></td>
            </tr>
          <tr>
            <td valign="top">Alamat</td>
            <td valign="top">:</td>
            <td><?php echo $pasien['almt_lengkap'];?></td>
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
    <form id="form1" name="form1" action="surat_persetujuan_latin_jantung_utils.php" method="post">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idUser" value="<?=$idUser?>" />
    <input type="hidden" name="idPasien" value="<?=$idPasien?>" />
    <input type="hidden" name="txtId" id="txtId"/>
    <input type="hidden" name="act" id="act" value="tambah"/>
    <table cellspacing="0" cellpadding="0" style="border:1px solid #000000">
  <col width="36" />
  <col width="23" span="2" />
  <col width="64" span="7" />
  <col width="120" />
  
  <tr height="20">
    <td colspan="11" align="left" valign="top"><table cellpadding="0" cellspacing="0" style="border:outset #000000">
      <tr>
        
        <td><img src="b.png" width="360" height="62" /></td><td><img src="c.png" width="330" height="80" /></td>
      </tr>
  </table>  </tr>
  
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="10">Saya yang bertanda tangan di bawah    ini, memberikan ijin kepada dr. <strong><?php echo $usr['nama'];?></strong></td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="10">untuk    melakukan uji latih jantung berbeban atas diri saya, guna Penilaian Fungsi    dan Kapasitas jantung,</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="4">paru dan pembuluh darah</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="9">Saya telah memahami penjelasan yang    diberikan kepada saya sebagai berikut :</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>1.</td>
    <td colspan="8">Bahwa    saya akan berjalan/berlari/diinfus obat pada alat uji latih jantung ini    dengan kecepatan</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="8">derajat    kemiringan dari  lantai berpijak atau    beban yang semakin meningkat setiap 2-3 menit</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="8">sampai    pada batas yang telah ditargetkan, kelelahan, sesak napas, nyeri dada dan    gejala lainnya </td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="6">atau sampai dihentikan oleh petugas    (perawat atau dokter)</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>2.</td>
    <td colspan="8">Bahwa    resiko uji latih dapat berupa perubahan irama jantung, kemungkinan perubahan    tekanan </td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="8">darah    yang berlebihan yang dapat menyebabkan pingsan atau serangan jantung.</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>3.</td>
    <td colspan="8">Bahwa    petugas akan melakukan upaya untuk meminimalkan kemungkinan di atas    dengan </td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="4">peralatan yang ada di rumah sakit.</td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>4.</td>
    <td colspan="7">Bahwa tidak ada jaminan atau garansi    akan hasil dari uji latih ini.</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td colspan="5">Medan, <?=tgl_ina(date('Y-m-d'));?></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td colspan="5">(<strong><u> <?php echo $usr2['nama'];?> </u></strong>)</td>
    <td></td>
    <td colspan="3">(<input name="saksi" id="saksi" style="width:200px" type="text"/>)</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td colspan="5">Nama &amp; Tanda Tangan Pasien</td>
    <td></td>
    <td colspan="3">Nama &amp;    Tanda Tangan Saksi</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20"></td>
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
  <tr height="20">
    <td height="20"></td>
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
  <tr height="20">
    <td height="20"></td>
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
  <tr height="20">
    <td height="20"></td>
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
  <tr height="20">
    <td height="20"></td>
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
  <tr height="20">
    <td height="20"></td>
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
  <tr height="20">
    <td height="20" colspan="11" align="center"> (<strong><u> <?php echo $usr['nama'];?></u></strong> )</td>
  </tr>
  <tr height="20">
    <td height="20" colspan="11"><div align="center">Nama &amp; Tanda Tangan Dokter</div></td>
  </tr>
  <tr height="20">
    <td height="20" colspan="11"></td>
  </tr>
  <tr id="trTombol">
        <td colspan="11" class="noline" align="center">
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
		window.open('surat_persetujuan_latin_jantung.php?idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>&idPasien=<?=$idPasien?>&id='+rowid,"_blank");
				//}
		}
        //////////////////fungsi untuk tindakan////////////////////////
        function simpan(action)
        {
            /*if(ValidateForm('saksi,idPel','ind'))
            {*/
                $("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						
					  },
					});
					batal();
						a.loadURL("surat_persetujuan_latin_jantung_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
						//goFilterAndSort();
          //  }
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
			var sisip=a.getRowId(a.getSelRow()).split("|");
            var p="txtId*-*"+sisip[0]+"*|*saksi*-*"+a.cellsGetValue(a.getSelRow(),3)+"";
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
			var p="txtId*-**|*saksi*-*";
			fSetValue(window,p);
			
		}
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
                a.loadURL("surat_persetujuan_latin_jantung_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("SURAT PERSETUJUAN UJI LATIH JANTUNG BERBEBAN");
        a.setColHeader("NO,Pasien,Saksi,Dokter");
        a.setIDColHeader(",,saksi,");
        a.setColWidth("40,200,200,200");
        a.setCellAlign("center,left,left,left");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("surat_persetujuan_latin_jantung_utils.php?grd=true"+"&idPel=<?=$idPel?>"+"&idKunj=<?=$idKunj?>");
        a.Init();
	
	
	function toggle() {
    parent.alertsize(document.body.scrollHeight);
}

    </script>
</html>

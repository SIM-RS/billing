<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));

include("setting.php")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <!-- end untuk ajax-->
        <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
                <script type="text/javascript">
$(function () 
{
	$('#txtJam').timeEntry({show24Hours: true, showSeconds: true});
	$('#txtJam1').timeEntry({show24Hours: true, showSeconds: true});
	$('#txtJam2').timeEntry({show24Hours: true, showSeconds: true});
});
  var arrRange = depRange = [];
</script>
        <title>PEMERIKSAAN RADIOLOGI 3</title>
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
    </head>
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
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
          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" bordercolor="#FF0000" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="pemeriksaanRADIOLOGI3_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
                
<table width="847" border="0" style="border-collapse:collapse; font:12px tahoma ">
  <tr>
    <td width="841" height="134"><table width="99%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="53%" height="69"><span class="style1">RS PELINDO I </span></td>
        <td width="47%" rowspan="2"><table width="100%" border="0" style="border:1px solid #000000; font:12px tahoma">
          <tr>
            <td width="26%">Nama Pasien </td>
            <td width="2%">:</td>
            <td colspan="2"> <?=$nama;?> (<?=$sex;?>)</td>
            </tr>
          <tr>
            <td>Tanggal Lahir </td>
            <td>:</td>
            <td width="34%"><?=$tgl;?> </td>
            <td>Usia : 
              <?=$umur;?> 
              th </td>
            </tr>
          <tr>
            <td>No. RM </td>
            <td>:</td>
            <td><?=$noRM;?></td>
            <td>No. registrasi: &nbsp;<? echo $noreg1;?></td>
            </tr>
          <tr>
            <td>Ruang Rawat / Kelas </td>
            <td>:</td>
            <td colspan="2"><?=$kamar;?> / <?=$kelas;?></td>
            </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td colspan="2"><?=$alamat;?></td>
            </tr>
          <tr>
            <td height="40" colspan="4"><div align="center">(Tempelkan Stiker Identitas Pasien) </div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="51"><span class="style2">PERMINTAAN PEMERIKSAAN RADIOLOGI 3 </span></td>
      </tr>
    </table></td>
  </tr>
  <?
  $sql21="SELECT b.id, b.nama FROM b_pelayanan a
INNER JOIN b_ms_pegawai b ON a.dokter_id = b.id
WHERE a.pasien_id = $id_pasien AND unit_id = 61 
ORDER BY id DESC
LIMIT 1"; //echo $sql;
$hasil21=mysql_query($sql21);
$data21=mysql_fetch_array($hasil21);
?>

  <tr>
    <td><table width="99%" border="0" style="border:1px solid #000000; font:12px tahoma">
      <tr>
        <td><table width="99%" border="0">
          <tr>
            <td height="30">Nama Dokter Pengirim </td>
            <td>: <?php echo $data21['nama']?></td>
            <td style="border:1px solid #000000">No. Formulir : <input type="text" name="txt_noForm" id="txt_noForm" /></td>
          </tr>
          <tr>
            <td>Permohonan yang diminta harap dicentang</td>
            <td colspan="2">: 
              <input type="checkbox" name="isi_chk[0]" value="1" id="isi_chk[]" />
              Biasa&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="isi_chk[1]" value="2" id="isi_chk[]" />
              Cito&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
              <input type="checkbox" name="isi_chk[2]" value="3" id="isi_chk[]" />
			  Hasil Diserahkan Ke Dokter&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
              <input type="checkbox" name="isi_chk[3]" value="4" id="isi_chk[]" />
			  Hasil Diserahkan ke Pasien</td>
            </tr>
          
          <tr>
            <td>Diagnosa / Keterangan Klinik </td>
            <td>:&nbsp;<input type="hidden" id="diagnosa" name="diagnosa" value="<?php echo $diag ?>" /><?php echo $diag ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><em><strong>M R I (MAGNETIC RESONANCE IMAGING) </strong></em></td>
          </tr>
          <tr>
            <td>
              <div align="center">
                <input type="checkbox" name="isi_chk[4]" value="5" id="isi_chk[]" />
                <strong>CONTRAS</strong></div></td>
            <td colspan="2">
              <div align="center">
                <input type="checkbox" name="isi_chk[5]" value="6" id="isi_chk[]" />
                <strong>NON CONTRAS </strong></div></td>
            </tr>
          <tr>
            <td width="33%"><strong>CRANIUM</strong></td>
            <td width="34%"></td>
            <td width="33%"></td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" name="isi_chk[6]" value="7" id="isi_chk[]" />
              MRI Brain/Neurocranium </td>
            <td>
              <input type="checkbox" name="isi_chk[7]" value="8" id="isi_chk[]" />
              MRI Temporallobe (Epilepsi) </td>
            <td><input type="checkbox" name="isi_chk[8]" value="9" id="isi_chk[]" />
              MRI Spetriscopy </td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" name="isi_chk[9]" value="10" id="isi_chk[]" />
              MRI Hipofise           </td>
            <td>
              <input type="checkbox" name="isi_chk[10]" value="11" id="isi_chk[]" /> 
              MRI Cochlea/IAC           </td>
            <td><input type="checkbox" name="isi_chk[11]" value="12" id="isi_chk[]" />
              MRI Perfusion </td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" name="isi_chk[12]" value="13" id="isi_chk[]" />
              MRI Dynamic Hipofise </td>
            <td>
              <input type="checkbox" name="isi_chk[13]" value="14" id="isi_chk[]" />
              MRI Brain Mapping/Functional          </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" name="isi_chk[14]" value="15" id="isi_chk[]" /> 
              MRI Orbita </td>
            <td>
              <input type="checkbox" name="isi_chk[15]" value="16" id="isi_chk[]" /> 
              MRI Tractography/DTI </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>NECK</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[16]" value="17" id="isi_chk[]" />
MRI Sinus Paranasal </td>
            <td><input type="checkbox" name="isi_chk[17]" value="18" id="isi_chk[]" />
              MRI TMJ </td>
            <td><input type="checkbox" name="isi_chk[18]" value="19" id="isi_chk[]" />
              MRI Parotis </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[19]" value="20" id="isi_chk[]" />
              MRI Nasopharynx </td>
            <td><input type="checkbox" name="isi_chk[20]" value="21" id="isi_chk[]" />
              MRI Larynx </td>
            <td><input type="checkbox" name="isi_chk[21]" value="22" id="isi_chk[]" />
              MRI Larynx </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[22]" value="23" id="isi_chk[]" />
              MRI Salvilary Gland </td>
            <td><input type="checkbox" name="isi_chk[23]" value="24" id="isi_chk[]" />
              MRI Thyroid </td>
            <td><input type="checkbox" name="isi_chk[24]" value="25" id="isi_chk[]" />
              MRI Thyroid </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>THORAX</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[25]" value="26" id="isi_chk[]" />
              MRI Mediastium </td>
            <td><input type="checkbox" name="isi_chk[26]" value="27" id="isi_chk[]" />
              MRI Breast </td>
            <td><input type="checkbox" name="isi_chk[27]" value="28" id="isi_chk[]" />
              MRI Dynamic Breast </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>SPINE</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[28]" value="29" id="isi_chk[]" />
              MRI Cervinal </td>
            <td><input type="checkbox" name="isi_chk[29]" value="30" id="isi_chk[]" />
              MRI Lumbosacral </td>
            <td><input type="checkbox" name="isi_chk[30]" value="31" id="isi_chk[]" />
              MRI Whole Spine Sagital T2 </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[31]" value="32" id="isi_chk[]" />
              MRI Thoracal </td>
            <td><input type="checkbox" name="isi_chk[32]" value="33" id="isi_chk[]" />
              MRI Sacral/Coccygeus </td>
            <td><input type="checkbox" name="isi_chk[33]" value="34" id="isi_chk[]" />
              MRI Whole Spine </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>ABDOMEN + PELVIS </strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[34]" value="35" id="isi_chk[]" />
              MRI Upper Abdomen </td>
            <td><input type="checkbox" name="isi_chk[35]" value="36" id="isi_chk[]" />
              MRI Whole Abdomen </td>
            <td><input type="checkbox" name="isi_chk[36]" value="37" id="isi_chk[]" />
              MRI Whole Body Diffusion </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[37]" value="38" id="isi_chk[]" />
              MRI Lower Abdomen (Pelvis) </td>
            <td><input type="checkbox" name="isi_chk[38]" value="39" id="isi_chk[]" />
              MRCP (Cholangiopancreaticogram) </td>
            <td><input type="checkbox" name="isi_chk[39]" value="40" id="isi_chk[]" />
              MRI Dynamic Hepar </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>MUSCULOSKELETAL</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" name="isi_chk[40]" value="41" id="isi_chk[]" /> 
              MRI Shoulder Dextra/Sinistra </td>
            <td><input type="checkbox" name="isi_chk[41]" value="42" id="isi_chk[]" />
              MRI Wrist Dwxtra/Smistra </td>
            <td><input type="checkbox" name="isi_chk[42]" value="43" id="isi_chk[]" />
              MRI Cruris Dextra/Sinistra </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[43]" value="44" id="isi_chk[]" />
              MRI Humerus Dextra/Sinistra </td>
            <td><input type="checkbox" name="isi_chk[44]" value="45" id="isi_chk[]" />
              MRI Manus Dextra/Sinistra</td>
            <td><input type="checkbox" name="isi_chk[45]" value="46" id="isi_chk[]" />
              MRI Ankle Dextra/Sinistra </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[46]" value="47" id="isi_chk[]" /> 
              MRI Elbow Dextra/Sinistra </td>
            <td><input type="checkbox" name="isi_chk[47]" value="48" id="isi_chk[]" />
              MRI Hip Dextra/Sinistra </td>
            <td><input type="checkbox" name="isi_chk[48]" value="49" id="isi_chk[]" />
              MRI Pedis Dextra/Sinistra </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[49]" value="50" id="isi_chk[]" />
              MRI Antebrachi Dextra/Sinistra </td>
            <td><input type="checkbox" name="isi_chk[50]" value="51" id="isi_chk[]" />
              MRI Femur Dextra/Sinistra </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong>ANGIOGRAPHY</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[51]" value="52" id="isi_chk[]" />
              MRA Brain/Neurocranium
</td>
            <td><input type="checkbox" name="isi_chk[52]" value="53" id="isi_chk[]" />
              MRI + MRA Spectroscopy Brain </td>
            <td><input type="checkbox" name="isi_chk[53]" value="54" id="isi_chk[]" />
              MRA Upper Extremitas </td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[54]" value="55" id="isi_chk[]" />
              MRV Brain/Neurocranium
</td>
            <td><input type="checkbox" name="isi_chk[55]" value="56" id="isi_chk[]" />
              MRI + MRA + MRV Brain </td>
            <td><input type="checkbox" name="isi_chk[56]" value="57" id="isi_chk[]" />
MRA Lower Extremitas </td>
          </tr>
          <tr>
            <td>
              <input type="checkbox" name="isi_chk[57]" value="58" id="isi_chk[]" />
              MRA Carotis </td>
            <td><input type="checkbox" name="isi_chk[58]" value="59" id="isi_chk[]" />
              MRA Abdominal </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="checkbox" name="isi_chk[59]" value="60" id="isi_chk[]" />
              MRI + MRA Brain </td>
            <td><input type="checkbox" name="isi_chk[60]" value="61" id="isi_chk[]" />
              MRA Renal </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="right">FORM-RAD-03-00</div></td>
  </tr>
</table> 
             </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%">
                        <?php if($_REQUEST['report']!=1){?><input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/><?php }?>
                  </td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
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
                    <td align="center" colspan="3">
                        <div id="gridbox" style="width:700px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:700px;"></div></td>
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
  <!--    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="<?=$host?>/simrs-tangerang/billing/index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
        </tr>
          </table>-->
        </div>
    </body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('txt_noForm','ind')){
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
            Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
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
            var sisip = a.getRowId(a.getSelRow()).split('|');
			//$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#txt_noForm').val(sisip[1]);
			$('#act').val('edit');
			centang(sisip[2]);
			alert(tes);

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
		
		function resetF(){
			$('#act').val('tambah');
			$('#txtId').val('');
			document.form1.reset();
           
			//centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
            /*var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');
                }
            }*/

        }

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("pemeriksaanRADIOLOGI3_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Pemeriksaan Radiologi 3");
        a.setColHeader("NO,NO RM,NO FORMULIR,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("100,150,100,150,200");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("pemeriksaanRADIOLOGI3_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
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
		window.open("pemeriksaanRADIOLOGI3.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes)
{
		//var list=tes.split('*=*');
//		var list1 = document.form1.elements['radio[]'];
		var list2 = document.form1.elements['isi_chk[]'];
				 
/*		if ( list1.length > 0 )
		{
		 for (i = 0; i < 41; i++)
			{
			var val=list[0].split(',');	
			var listx = document.form1.elements['radio['+i+']'];
					//alert('radio['+i+']');
			for (j = 0; j < listx.length; j++)
				{
				if (listx[j].value==val[i])
			  		{
			   			listx[j].checked = true;
			  		}
				else
					{
						listx[j].checked = false;
					}	
				}
		  }
		}*/
		
		if ( list2.length > 0 )
		{
		 for (i = 0; i < list2.length; i++)
			{
			var val=tes.split(',');
			  if (list2[i].value==val[i])
			  {
			   list2[i].checked = true;
			  }else{
					list2[i].checked = false;
					}
		  }
		}
	}
    </script>
    
</html>
